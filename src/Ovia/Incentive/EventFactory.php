<?php

namespace Ovia\Incentive;

/**
 * EventFactory is responsible for instantiating the correct Event type.
 *
 * This factory takes the JSON document received from SQS and instantiates an
 * appropriate Event instance from it. This is an important part of the
 * implementation, since it is part of the design that allows the system to
 * be expanded in the future.
 *
 * Should the need for a new event type arise, name the event, create a new
 * subclass of AbstractEvent to represent it, and this factory will instantiate
 * the new event.
 *
 * The part that is missing here is the process that reads the event data in
 * JSON format from SQS and calls this factory to instantiate the event. This
 * is the
 */
class EventFactory
{
    /**
     * Converts the specified JSON string into an event instance.
     *
     * @param string $json
     *   The JSON document read from SQS.
     *
     * @return Event
     *   The event representing the specified JSON document.
     *
     * @throws InvalidEventException
     *   If there are missing fields or the field values are the wrong type.
     */
    public static function fromJSON($json)
    {
        if (!is_string($json)) {
            throw new \InvalidArgumentException(
                'The "json" parameter must be a string.'
            );
        }
        $event_object = json_decode($json);
        if ($event_object === null) {
            throw new \InvalidArgumentException(
                'The "json" parameter must contain a valid JSON document'
            );
        }
        self::validate($event_object);

        return self::getEventInstance($event_object);
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
    private static function validate($event_object)
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
     * Returns an Event instance representing the specified event object.
     *
     * @param object $event_object
     *   The event object.
     *
     * @return Event
     *   The Event instance suitable for representing the event.
     *
     * @throws InvalidEventException
     *   If there is no event class for the specified event_name field.
     */
    private static function getEventInstance($event_object) {
        $class_name = sprintf('Ovia\Incentive\%sEvent', $event_object->name);
        try {
            $class = new \ReflectionClass($class_name);
            try {
                $method = $class->getMethod('fromObject');
                $result = $method->invoke(null, $event_object);
                if (!$result instanceof Event) {
                    throw new InvalidEventException(sprintf(
                        'The "%s" class failed to return an Event instance from the "fromObject" method.',
                        $class_name
                    ));
                }
                return $result;
            }
            catch (\ReflectionException $e) {
                throw new InvalidEventException(sprintf(
                    'The "%s" class is missing the "fromObject" static method.',
                    $class_name
                ));
            }
        }
        catch (\ReflectionException $e) {
            throw new InvalidEventException(sprintf(
                'No corresponding Event class found for event_name "%s".',
                $event_object->name
            ));
        }
    }
}
