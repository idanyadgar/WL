<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Not found 404 Error.<br />
     * Error code: 404.
     *
     * @package System\Exceptions
     */
    class NotFoundException extends Exception {
        /**
         * @param Exception $previous The previous exception used for the exception chaining.
         */
        public function __construct(Exception $previous = null) {
            parent::__construct("Not Found: {$_SERVER['REQUEST_URI']}", 404, $previous);
        }
    }
}