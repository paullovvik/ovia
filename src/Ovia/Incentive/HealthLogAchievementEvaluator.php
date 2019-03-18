<?php

/**
 * @file Contains the HealthLogAchievement class.
 */

namespace Ovia\Incentive;

/**
 * Evaluates whether the HealthLogAchievement should be awarded.
 */
class HealthLogAchievementEvaluator
{
    /**
     * Evaluates whether the achievement has been accomplished.
     *
     * This method is responsible for determining whether the specified event
     * indicates the achievement has been accomplished.
     *
     * @param Event $event
     *   An incoming event.
     *
     * @return bool
     *   true if the specified event concludes the accomplishment of the
     *   event; false otherwise.
     */
    public function AchievementAccomplished(Event $event)
    {
        if (!$event instanceof HealthLogEvent) {
            return false;
        }
        // Note that I am missing all of the storage classes, so bear with me
        // here. First, verify that the HealthLog achievement has not yet been
        // achieved. if so, simply return FALSE, since this event does not
        // determine whether the HealthLog achievement has been accomplished.

        // I'm going to calculate the Unix timestamp of 5 days ago so that I
        // can easily perform a database query to get the HealthLog event
        // instances from only the last 5 days. Note that this code does not
        // take into account timezones, which production code will need to do.
        $from_timestamp = strtotime(
            date('Y-m-d', strtotime('-5 days', $event->getTime()))
        );

        // Now perform a database query on the "events" table using the user_id,
        // event name, and time.
        // SELECT * FROM events WHERE name = 'HealthLog' AND
        //     time >= $from_timestamp AND user_id = $event->getUserID();

        // For ease of calculation, calculate the last second of today. Then each
        // event time
        $today = strtotime(
            date('Y-m-d', strtotime('+1 days', $event->getTime()))
        ) - 1;
        $seconds_in_a_day = 24*60*60;

        // This array will indicate for each day within the last 5 days whether
        // a HealthLog update was made. The first entry is TRUE because the
        // event was received on the last day of the test. The order of the
        // array indexes is...
        // 0 - today      => today - 0 days
        // 1 - yesterday  => today - 1 days
        // 2 - 2 days ago => today - 2 days
        // ...
        $history = [true, false, false, false, false];

        // This isn't totally right because I'm not showing the conversion of
        // the SQL result into a proper Event instance. Assume $results is an
        // Event array.
        /**
         * Fix up the result type for remaining code.
         *
         * @var Event[] $results
         */
        foreach ($results as $result) {
            $days_ago = ($today - $result->getTime()) / $seconds_in_a_day;
            $history[$days_ago] = true;
        }

        // Finally verify we have a HealthLog event for each of the past 5 days.
        for ($i = 0; $i < 5; $i++) {
            if (!$history[$i]) {
                return false;
            }
        }
        return false;
    }
}
