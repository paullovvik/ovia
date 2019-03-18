<?php

namespace Ovia\Incentive;

/**
 * AbstractAchievement implements methods common to all achievements.
 */
class AbstractAchievement implements Achievement
{
    /**
     * The user ID.
     *
     * @var int
     */
    private $uid = null;

    /**
     * The Achievement time, represented as a Unix timestamp.
     *
     * @var int
     */
    private $time = null;

    /**
     * The Achievement name.
     *
     * @var string
     */
    private $name = null;

    /**
     * {@inheritdoc}
     */
    public function getUserID()
    {
        return $this->uid;
    }

    /**
     * Sets the user ID.
     *
     * @param int $uid The user ID.
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
    public function name()
    {
        return $this->name;
    }

    /**
     * Sets the achievement name, which indicates the type of achievement.
     *
     * @param string $name
     */
    protected function setName($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new \InvalidArgumentException(
                'The "name" parameter must be a string indicating the name of the achievement.'
            );
        }
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Sets the achievement time.
     *
     * @param int $time
     *   A Unix timestamp representing the time this achievement was accomplished.
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

}
