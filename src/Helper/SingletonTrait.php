<?php

trait SingletonTrait
{
    /**
     * @var $this
     */
    protected static $instance = null;

    /**
     * SingletonTrait constructor.
     *
     * can be overidden
     */
    private function __construct()
    {
    }

    /**
     * can be overriden
     */
    private function __clone()
    {
    }

    /**
     * @return $this
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}
