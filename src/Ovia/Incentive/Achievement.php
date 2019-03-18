<?php

namespace Ovia\Incentive;

/**
 * Achievement represents an achievement a particular user has earned.
 * Achievements are stored indefinitely within the system, serving as a record
 * of user accomplishments.
 */
interface Achievement
{
    /**
     * Gets the user ID associated with the achievement.
     *
     * @return int
     *   The user ID.
     */
    public function getUserID();

    /**
     * Gets the achievement name.
     *
     *   The achievement name is a string that represents a class of
     *   achievement. Multiple partners may wish to be notified of a particular
     *   achievement, such as the birth of a baby. Using an achievement name,
     *   multiple partners can be tied to the same achievement and be notified
     *   as required.
     *
     * @return string
     *   The achievement name.
     */
    public function name();

    /**
     * Gets the time the achievement was accomplished.
     *
     * @return int
     *   The time this achievement was accomplished, represented by a Unix
     *   timestamp.
     */
    public function getTime();

}
