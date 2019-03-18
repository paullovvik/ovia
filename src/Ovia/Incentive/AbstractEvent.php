<?php

namespace Ovia\Incentive;

/**
 * AbstractEvent implements methods common to all events.
 */
abstract class AbstractEvent implements Event
{

    /**
     * The user ID.
     *
     * @var int
     */
    private $uid = null;

    /**
     * The event time, represented as a Unix timestamp.
     *
     * @var int
     */
    private $time = null;

    /**
     * The event name.
     *
     * @var string
     */
    private $name = null;

    /**
     * Sets the user ID.
     *
     * @param int $uid
     *   The user ID.
     */
    protected function setUserId($uid)
    {
        if (!is_int($uid) || $uid < 0) {
            throw new \InvalidArgumentException(
                'The "uid" parameter must be a positive integer.'
            );
        }
        $this->uid = $uid;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserID()
    {
        return $this->uid;
    }

    /**
     * Sets the event time.
     *
     * @param int $time
     *   A Unix timestamp representing the time this event was sent.
     */
    protected function setTime($time)
    {
        if (!is_int($time) || $time < 0) {
            throw new \InvalidArgumentException(
                'The "time" parameter must be a valid Unix timestamp.'
            );
        }
        $this->time = $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Sets the event name, which indicates the type of event.
     *
     * @param string $name
     */
    protected function setName($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new \InvalidArgumentException(
                'The "name" parameter must be a string indicating the name of the event.'
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Validates the object fields that were decoded from JSON.
     *
     * @param object $event_object
     *   The decoded event object sent through SQS as JSON.
     *
     * @throws InvalidEventException
     *   If there are missing fields or the field values are the wrong type.
     */
    protected static function validateEventObject($event_object)
    {
        if (!isset($event_object->user_id)) {
            throw new InvalidEventException(
                'Event is missing the "user_id" field.'
            );
        }
        if (!is_int($event_object->user_id) || $event_object->user_id <= 0 ) {
            throw new InvalidEventException(
                'The "user_id" field must be a positive integer.'
            );
        }
        if (!isset($event_object->event_name)) {
            throw new InvalidEventException(
                'Event is missing the "event_name" field.'
            );
        }
        if (!is_string($event_object->event_name) || empty($event_object->event_name)) {
            throw new InvalidEventException(
                'The "event_name" field must be a string representing the event name.'
            );
        }
        if (!isset($event_object->time)) {
            throw new InvalidEventException(
                'Event is missing the "time" field.'
            );
        }
        if (!is_int($event_object->time) || $event_object->time <=0) {
            throw new InvalidEventException(
                'The "time" field must be an integer representing a valid Unix timestamp.'
            );
        }
    }

    /**
     * Populates common fields from the plain object into the newly created AbstractEvent.
     *
     * @param object $event_object
     *   The plain object that originated from a JSON string.
     * @param AbstractEvent $event
     *   The correctly-typed Event class that will be populated.
     *
     * @throws InvalidEventException
     *   If the specified $event_object parameter is missing one or more fields
     *   or has a field with the wrong type.
     */
    protected static function populateObject($event_object, AbstractEvent $event)
    {
        if (!isset($event_object->user_id)) {
            throw new InvalidEventException(
                'Event is missing the "user_id" field.'
            );
        }
        if (!is_int($event_object->user_id) || $event_object->user_id <= 0 ) {
            throw new InvalidEventException(
                'The "user_id" field must be a positive integer.'
            );
        }
        $event->setUserID($event_object->user_id);


        if (!isset($event_object->time)) {
            throw new InvalidEventException('Event is missing the "time" field.');
        }
        if (!is_int($event_object->time) || $event_object->time <=0) {
            throw new InvalidEventException(
                'The "time" field must be an integer representing a valid Unix timestamp.'
            );
        }
        $event->setTime($event_object->time);
    }

}
