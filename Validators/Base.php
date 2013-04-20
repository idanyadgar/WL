<?php
namespace Validators {

    /**
     * The base validator which contains the default validator methods.
     *
     * @package Validators
     */
    abstract class Base {
        /**
         * Checks if a property contains an actual value.
         *
         * @param mixed $property The property to check.
         *
         * @return boolean True if <var>$property</var> contains an actual value or false otherwise.
         */
        public static function Required($property) {
            return !is_null($property) && $property != '';
        }

        /**
         * Checks if the string length of a property is between <var>$min</var> and <var>$max</var>.
         *
         * @param string $min      The minimum Length.
         * @param string $max      The maximum Length.
         * @param mixed  $property The property to check.
         *
         * @return boolean True if <var>$property</var> length is between <var>$min</var> and <var>$max</var>.
         */
        public static function Length($min, $max, $property) {
            $length = mb_strlen($property);
            return intval($min) <= $length && $length <= intval($max);
        }
    }
}