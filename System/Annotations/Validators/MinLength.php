<?php
namespace System\Annotations\Validators {
    use System\Annotations\Validator;

    /**
     * Represents a validator which checks a minimum string-length. 
     *
     * @package System\Annotations\Validators
     */
    class MinLength extends Validator {
        /**
         * @var integer The minimum length allowed.
         */
        private $_min; 

        /**
         * @param integer $min          The minimum length allowed.
         * @param string  $errorMessage The message in case of error.
         */
        public function __construct($min, $errorMessage = '{0} length must be greater than {1}') {
            parent::__construct();
            $this->_errorMessage = $errorMessage;
            $this->_min = intval($min);
        }
        
        public function validate($object) {
            return $this->_min <= mb_strlen($object->{$this->property});
        }
    }
}