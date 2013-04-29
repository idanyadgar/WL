<?php
namespace System\Annotations\Validators {
    use DateTime;
    use Exception;
    use System\Annotations\Validator;

    /**
     * Represents a validator which checks date validation.
     *
     * @package System\Annotations\Validators
     */
    class Date extends Validator {
        /**
         * @param string $errorMessage The message in case of error.
         */
        public function __construct($errorMessage = '{0} is not a valid date') {
            parent::__construct();
            $this->_errorMessage = $errorMessage;
        }
        
        public function validate($object) {
            if ($object->{$this->property} instanceof DateTime) {
                return true;
            }
            if (is_null($object->{$this->property}) || trim($object->{$this->property}) == '') {
                return false;
            }
            try {
                new DateTime((string)$object->{$this->property});
                return count(DateTime::getLastErrors()['warnings']) == 0;
            }
            catch (Exception $e) {
                return false;
            }
        }
    }
}