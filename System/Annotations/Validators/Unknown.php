<?php
namespace System\Annotations\Validators {
    use System\Annotations\Validator;

    /**
     * Represents a validator with an unknown type.<br />
     * This validator is ignored (returns true always).
     *
     * @package System\Annotations\Validators
     */
    class Unknown extends Validator {

        public function __construct() {
            parent::__construct();
        }
        
        public function validate($object) {
            return true;
        }
    }
}