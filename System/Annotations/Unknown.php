<?php
namespace System\Annotations {
    use Reflector;
    use System\Annotation;

    /**
     * Represents an annotation which has an unknown tag.
     * 
     * @package System\Annotations
     */
    class Unknown extends Annotation {
        /**
         * @param string $value The value of the annotation.
         */
        public function __construct($value) {
            parent::__construct($value);
        }
    }
}