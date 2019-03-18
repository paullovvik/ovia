<?php

namespace Ovia\Incentive;

/**
 * HealthLogEvent is sent when a user logs their health status.
 */
class HealthLogEvent extends AbstractEvent
{
    /**
     * {@inheritdoc}
     */
    public static function fromObject($event_object)
    {
        if (!isset($event_object->event_name)) {
            throw new InvalidEventException(
                'Event is missing the "event_name" field.'
            );
        }
        if ($event_object->event_name !== 'HealthLog') {
            throw new \InvalidArgumentException(sprintf(
                'The "event_object->event_name" expected to be "HealthLog", found "%s" instead',
                $event_object->event_name
            ));
        }

        $event = new HealthLogEvent();
        parent::populateObject($event_object, $event);
        return $event;
    }

}