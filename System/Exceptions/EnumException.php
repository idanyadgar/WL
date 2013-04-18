<?php
namespace System\Exceptions {
    use Exception;

    /**
     * Enum option does not exist error.<br />
     * Error code: 103.
     *
     * @package System\Exceptions
     */
    class EnumException extends Exception {
        /**
         * @param string $enum   The enum where the Exception occurred.
         * @param string $option The selected option.
         */
        public function __construct($enum, $option) {
            parent::__construct("'$option' is undefined in '$enum' enum'", 103);
        }
    }
}