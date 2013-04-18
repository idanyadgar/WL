<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Inaccessible method call Error.<br />
     * Error code: 104.
     *
     * @package System\Exceptions
     */
    class InAccessibleMethodException extends Exception {
        /**
         * @param Exception $previous The previous exception used for the exception chaining.
         */
        public function __construct(Exception $previous = null) {
            parent::__construct("Inaccessible method was called", 104, $previous);
        }
    }
}