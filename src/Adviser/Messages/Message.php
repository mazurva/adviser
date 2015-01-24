<?php namespace Adviser\Messages;

use InvalidArgumentException;

class Message {

    /**
     * @var integer
     */
    const NORMAL = 2;

    /**
     * @var integer
     */
    const WARNING = 3;

    /**
     * @var integer
     */
    const ERROR = 4;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var integer
     */
    protected $level;

    /**
     * @param string $message
     * @param int $level
     * @return Message
     */
    public function __construct($message, $level) {
        $this->message = (string) $message;
        $this->setLevel($level);
    }

    /**
     * Format the message according to its level.
     *
     * @return string
     */
    public function format() {
        switch ($this->level) {
            case static::NORMAL:  return "<info>{$this->message}</info>";
            case static::WARNING: return "<comment>{$this->message}</comment>";
            case static::ERROR:   return "<error>{$this->message}</error>";
        }
    }

    /**
     * Validate and set appropriate level.
     *
     * @throws InvalidArgumentException
     * @param integer $level
     * @return void
     */
    protected function setLevel($level) {
        if ( ! in_array($level, [static::NORMAL, static::WARNING, static::ERROR])) {
            throw new InvalidArgumentException;
        }

        $this->level = $level;
    }
}