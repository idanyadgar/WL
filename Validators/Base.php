<?php
namespace Validators {
    use DateTime;
    use Exception;

    /**
     * The base validator which contains the default validator methods.
     *
     * @package Validators
     */
    abstract class Base {
        /**
         * Checks if a property contains an actual value.
         *
         * @param mixed  $property The property to check.
         * @param string $notEmpty Whether the property can be an empty string or not.
         *
         * @return boolean True if <var>$property</var> contains an actual value or false otherwise.
         */
        public static function Required($property, $notEmpty = 'true') {
            if (is_array($property)) {
                return count($property) > 0;
            }
            if ($notEmpty == 'true' && $property === '') {
                return false;
            }
            return !is_null($property);
        }

        /**
         * Checks if the string length of a property is between <var>$min</var> and <var>$max</var>.
         *
         * @param mixed  $property The property to check.
         * @param string $min      The minimum Length.
         * @param string $max      The maximum Length.
         *
         * @return boolean True if <var>$property</var> length is between <var>$min</var> and <var>$max</var> or false otherwise.
         */
        public static function Length($property, $min, $max) {
            $length = mb_strlen($property);
            return intval($min) <= $length && $length <= intval($max);
        }

        /**
         * Checks if the string length og a property is greater than or equal to <var>$min</var>.
         *
         * @param mixed  $property The property to check.
         * @param string $min      The minimum length.
         *
         * @return boolean True if <var>$property</var> length is greater than or equal to <var>$min</var> or false otherwise.
         */
        public static function MinLength($property, $min) {
            return intval($min) <= mb_strlen($property);
        }

        /**
         * Checks if <var>$property</var> as a string is equal to <var>$string</var>.
         *
         * @param mixed  $property The property to check.
         * @param string $string   The string to check.
         *
         * @return boolean True if <var>$string</var> equals to <var>$property</var> or false otherwise.
         */
        public static function Compare($property, $string) {
            return (string)$property == $string;
        }

        /**
         * Checks if <var>$property</var> is a valid date.
         *
         * @param mixed $property The property to check.
         *
         * @return boolean True if <var>$property</var> is a valid date or false otherwise.
         */
        public static function Date($property) {
            if ($property instanceof DateTime) {
                return true;
            }
            if (is_null($property) || trim($property) == '') {
                return false;
            }
            try {
                new DateTime((string)$property);
                return count(DateTime::getLastErrors()['warnings']) == 0;
            }
            catch (Exception $e) {
                return false;
            }
        }
    }
}