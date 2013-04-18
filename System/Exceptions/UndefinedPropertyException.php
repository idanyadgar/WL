<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Used to throw an exception when an undefined property is called.<br />
     * Error code: 102.
     *
     * @package System\Exceptions
     */
    class UndefinedPropertyException extends Exception {
        /**
         * @param string $class    The class where the exception occurred.
         * @param string $property The wanted property.
         */
        public function __construct($class, $property) {
            parent::__construct("Undefined property: $class::$$property", 102);
        }
    }
}