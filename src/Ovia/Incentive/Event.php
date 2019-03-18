<?php

namespace Ovia\Incentive;

/**
 * An Event represents an event a particular user has generated. Events are
 * created in the Ovia backend as a result of user interactions and passed to
 * the Incentive service via SQS. The purpose of the event is to capture
 * behavior required to fulfill an achievement.
 */
interface Event {

    /**
     * Gets the user ID of the user that generated this event.
     *
     * @return int
     *   The user ID. Note this is an integer corresponding with a simple
     *   autoincrement field in a SQL table. For a more robust implementation I
     *   would use a UUID instead.
     */
    public function getUserID();

    /**
     * Gets the time the event was generated.
     *
     * @return int
     *   The event time, represented as a Unix timestamp.
     */
    public function getTime();

    /**
     * Gets the event name.
     *
     * The event name is a string that is agreed upon by the Ovia backend and
     * the incentive backend, and represents a particular type of event. For
     * example, this might be "Birth" for a birth event or "HealthLog" for an
     * event that represents the user entering health information.
     *
     * @return string
     *   The event name.
     */
    public function getName();

    /**
     * Constructs a new Event instance from the specified plain object.
     *
     * @param object $event_object
     *   The object decoded from the JSON data passed via SQS.
     *
     * @return Event
     *   The Event instance, fully initialized from the specified object data.
     *
     * @throws InvalidEventException
     *   If there are missing fields or the field values are the wrong type.
     */
    public static function fromObject($event_object);

}
