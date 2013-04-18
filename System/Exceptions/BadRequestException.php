<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Bad request 400 Error.<br />
     * Error code: 400.
     *
     * @package System\Exceptions
     */
    class BadRequestException extends Exception {
        /**
         * @param Exception $previous The previous exception used for the exception chaining.
         */
        public function __construct(Exception $previous = null) {
            parent::__construct("Bad Request: {$_SERVER['REQUEST_URI']}?{$_SERVER['QUERY_STRING']}", 400, $previous);
        }
    }
}