<?php
namespace Validators {

    /**
     * The base validator which contains the default validator methods.
     *
     * @package Validators
     */
    class Base {
        /**
         * Checks the string length of a property with a wanted <var>$length</var>.
         *
         * @param string $length   The wanted length of string.
         * @param mixed  $property The value to check.
         *
         * @return boolean True if <var>$property</var> length equals to <var>$length</var> or false otherwise.
         */
        public static function lengthIs($length, $property) {
            return mb_strlen($property) == $length;
        }

        /**
         * Checks if a property contains an actual value.
         *
         * @param mixed $property The property to check.
         *
         * @return boolean True if <var>$property</var> contains an actual value or false otherwise.
         */
        public static function required($property) {
            return !is_null($property) && $property != '';
        }

        public static function lengthBetween($min, $max, $property) {
            $length = mb_strlen($property);
            return $min <= $length && $length <= $max;
        }
    }
}