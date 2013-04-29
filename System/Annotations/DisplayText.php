<?php
namespace System\Annotations {
    use System\Annotation;

    /**
     * DisplayText annotation which determines the text that will be shown near a checkbox or radio button.
     *
     * @package System\Annotations
     */
    class DisplayText extends Annotation {
        /**
         * @param string $value The value of the annotation.
         */
        public function __construct($value) {
            parent::__construct($value);
        }
    }
}