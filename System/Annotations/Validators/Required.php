<?php
namespace System\Annotations\Validators {
    use System\Annotations\Validator;

    /**
     * Represents a validator which requires a value.
     *
     * @package System\Annotations\Validators
     */
    class Required extends Validator {
        /**
         * @var boolean Whether an empty string is valid or not.
         */
        private $_allowEmpty;

        /**
         * @param boolean $allowEmpty   Whether an empty string is valid or not.
         * @param string  $errorMessage The message in case of error.
         */
        public function __construct($allowEmpty = false, $errorMessage = '{0} is required') {
            parent::__construct();
            $this->_errorMessage = $errorMessage;
            $this->_allowEmpty   = $allowEmpty;
        }

        public function validate($object) {
            if (is_array($object->{$this->property})) {
                return count($object->{$this->property}) > 0;
            }
            if (!$this->_allowEmpty && $object->{$this->property} === '') {
                return false;
            }
            return !is_null($object->{$this->property});
        }
    }
}