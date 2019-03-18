<?php

namespace Ovia\Incentive;

/**
 * BirthEvent represents an event that is sent from the Ovia backend when a
 * user indicates a child was born. This event is an "Immediate" event, since
 * this single event can be translated directly into an achievement.
 */
class BirthEvent extends AbstractEvent
{
    /**
     * Sets the name of the child that was born.
     *
     * Note that in the case of multiple births, an event is required for each.
     *
     * @param string $child_name
     *   The name of the child.
     */
    protected function setChildName($child_name)
    {
        if (!is_string($child_name) || empty($child_name)) {
            throw new \InvalidArgumentException(
                'The "child_name" parameter must be a string containing the name of the child.'
            );
        }
    }

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
        if ($event_object->event_name !== 'Birth') {
            throw new \InvalidArgumentException(sprintf(
                'The "event_object->event_name" expected to be "Birth", found "%s" instead',
                $event_object->event_name
            ));
        }

        $event = new BirthEvent();
        parent::populateObject($event_object, $event);

        if (!isset($event_object->child_name)) {
            throw new InvalidEventException(
                'The "Birth" event is missing the "child_name" field.'
            );
        }
        $event->setChildName($event_object->child_name);
        return $event;
    }

}
