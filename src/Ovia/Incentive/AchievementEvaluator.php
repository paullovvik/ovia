<?php

namespace Ovia\Incentive;

interface AchievementEvaluator
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
     *   TRUE if the specified event concludes the accomplishment of the
     *   event; FALSE otherwise.
     */
    public function AchievementAccomplished(Event $event);

}