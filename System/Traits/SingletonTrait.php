<?php
namespace System\Traits {
    /**
     * This trait makes the class be a singleton.<br />
     * <b>* The construct must be private.</b>
     *
     * @package System\Traits
     */
    trait SingletonTrait {
        /**
         * @var self The instance of the class.
         */
        private static $instance;

        /**
         * Returns the instance of the class. If there is not any instance then a new one will be created.
         *
         * @return self The instance of the class.
         */
        public static function get() {
            if (!static::$instance instanceof static) {
                static::$instance = new static();
            }
            return static::$instance;
        }
    }
}