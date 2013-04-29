<?php
namespace System\Annotations {
    use System\Annotation;

    /**
     * Display name annotation which determines the what is name of the property in the client side.
     * 
     * @package System\Annotations
     */
    class DisplayName extends Annotation {
        /**
         * @param string $value The value of the annotation.
         */
        public function __construct($value) {
            parent::__construct($value);
        }
    }
}