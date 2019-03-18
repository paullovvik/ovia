<?php

namespace Ovia\Incentive;

/**
 * Evaluates whether the BirthAchievement should be awarded.
 */
class BirthAchievementEvaluator
{
    /**
     * {@inheritdoc}
     */
    public function AchievementAccomplished(Event $event)
    {
        if (!$event instanceof BirthEvent) {
            return false;
        }
        return true;
    }
}
