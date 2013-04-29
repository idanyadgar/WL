<?php
namespace System\Annotations {
    use System\Annotation;
    use System\Traits\Properties;

    /**
     * Attribute annotation which represents an html attribute.
     * 
     * @package System\Annotations
     * 
     * @property-read string $attribute The name of the attribute.
     * @property-read string $attrVal   The value of the attribute.
     */
    class Attribute extends Annotation {
        use Properties;

        /**
         * @var string The name of the attribute.
         */
        private $_attribute;
        /**
         * @var string The value of the attribute.
         */
        private $_attrVal;

        /**
         * @param string $value The value of the annotation.
         */
        public function __construct($value) {
            parent::__construct($value);
            list($this->_attribute, $this->_attrVal) = explode('=', $value, 2);
        }

        /**
         * Returns the name of the attribute.
         *
         * @return string The name of the attribute.
         */
        public function getAttribute() {
            return $this->_attribute;
        }

        /**
         * Returns the value of the attribute.
         *
         * @return string The value of the attribute.
         */
        public function getAttrVal() {
            return $this->_attrVal;
        }
    }
}