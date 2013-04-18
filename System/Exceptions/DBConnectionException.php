<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Database connection Error.<br />
     * Error code: 100.
     *
     * @package System\Exceptions
     */
    class DBConnectionException extends Exception {
        /**
         * @param string    $message  The error as it was received from the database.
         * @param string    $dsn      The DSN used in the connection.
         * @param string    $username The username used in the connection.
         * @param Exception $previous The previous exception used for the exception chaining.
         */
        public function __construct($message = '', $dsn = '', $username = '', Exception $previous = null) {
            parent::__construct("DB connection error: $message - (dsn: $dsn & username: $username)", 100, $previous);
        }
    }
}