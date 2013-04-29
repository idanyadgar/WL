<?php
namespace System\Annotations\Validators {
    use System\Annotations\Validator;

    /**
     * Represents a validator which checks length.
     *
     * @package System\Annotations\Validators
     */
    class Length extends Validator {
        /**
         * @var integer The minimum length allowed.
         */
        private $_min;
        /**
         * @var integer The maximum length allowed.
         */
        private $_max;

        /**
         * @param integer $min          The minimum length allowed.
         * @param integer $max          The maximum length allowed.
         * @param string  $errorMessage The message in case of error.
         */
        public function __construct($min, $max, $errorMessage = '{0} length must be between {1} and {2}') {
            parent::__construct();
            $this->_errorMessage = $errorMessage;
            $this->_min = intval($min);
            $this->_max = intval($max);
        }
        
        public function validate($object) {
            $length = mb_strlen($object->{$this->property});
            return $this->_min <= $length && $length <= $this->_max; 
        }
    }
}