<?php
namespace System\Annotations\Validators {
    use System\Annotations\Validator;

    /**
     * Represents a validation which compares between to properties.
     *
     * @package System\Annotations\Validators
     */
    class Compare extends Validator {
        /**
         * @var string The name og the property to compare.
         */
        private $_property;

        /**
         * @param string $property     The name of the property to compare.
         * @param string $errorMessage The message in case of error.
         */
        public function __construct($property, $errorMessage = '{0} and {1} must be identical') {
            parent::__construct();
            $this->_errorMessage = $errorMessage;
            $this->_property = $property;
        }
        
        public function validate($object) {
            return $object->{$this->property} === $object->{$this->_property};
        }
    }
}