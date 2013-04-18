<?php
namespace System\Enums {
    use ReflectionClass;
    use System\Exceptions\EnumException;

    /**
     * Simulates the enum structure.
     *
     * @package System\Enums
     */
    abstract class Enum {
        /**
         * @var string The selected option value.
         */
        private $val;
        /**
         * @var array All the created enums.
         */
        private static $cache = [];

        /**
         * @param string $val The selected option value.
         */
        private function __construct($val) {
            $this->val = $val;
        }

        /**
         * Returns a new instance of the enum class which represents the selected option.
         *
         * @param string $option The selected option.
         * @param array  $args   The arguments sent to the static function.
         *
         * @throws EnumException An exception is thrown when the wanted option does not exist.
         */
        public static function __callStatic($option, array $args) {
            $enum = get_called_class();
            if (array_key_exists("$enum::$option", self::$cache)) {
                return self::$cache["$enum::$option"];
            }
            if (defined("$enum::$option")) {
                return self::$cache["$enum::$option"] = new $enum(constant("$enum::$option"));
            }
            throw new EnumException($enum, $option);
        }

        /**
         * Returns an enum option from its value.
         *
         * @param string $string The string used in the search.
         *
         * @return Enum|boolean The option or false if it does not exist.
         */
        public static function getFromString($string) {
            $enum      = get_called_class();
            $constants = (new ReflectionClass($enum))->getConstants();
            $option    = array_search(strtolower($string), array_map('strtolower', $constants), true);
            return $option === false ? false : $enum::$option();
        }

        /**
         * @return string The value of the selected
         */
        public function __toString() {
            return $this->val;
        }
    }
}