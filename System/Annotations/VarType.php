<?php
namespace System\Annotations {
    use System\Annotation;

    /**
     * VarType annotation which indicates the type of the property.
     *
     * @package System\Annotations
     */
    class VarType extends Annotation {
        /**
         * @param string $value The value of the annotation.
         */
        public function __construct($value) {
            parent::__construct($value);
        }
    }
}