<?php
namespace System\Traits {
    use System\Exceptions\InAccessibleMethodException;
    use System\Exceptions\UndefinedPropertyException;

    /**
     * This trait simulates the properties system.
     *
     * @package System\Traits
     */
    trait PropertiesTrait {
        /**
         * Gets a value of a property.
         *
         * @param string $name The name of the property.
         *
         * @throws UndefinedPropertyException If the requested property does not have a getter.
         * @throws InAccessibleMethodException If the getter of the requested property cannot be accessible.
         *
         * @return mixed The wanted property.
         */
        public function __get($name) {
            if (!method_exists($this, "get$name")) {
                throw new UndefinedPropertyException(__CLASS__, $name);
            }
            $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            if (count($trace) < 2 || !accessible(__CLASS__, "get$name", $trace[1])) {
                throw new InAccessibleMethodException();
            }
            return call_user_func([$this, "get$name"]);
        }

        /**
         * Sets a value to a property.
         *
         * @param string $name  The name of the property.
         * @param mixed  $value The value of the property.
         *
         * @throws UndefinedPropertyException If the requested property does not have a setter.
         * @throws InAccessibleMethodException If the setter of the requested property cannot be accessible.
         */
        public function __set($name, $value) {
            if (!method_exists($this, "set$name")) {
                throw new UndefinedPropertyException(__CLASS__, $name);
            }
            $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            if (count($trace) < 2 || !accessible(__CLASS__, "set$name", $trace[1])) {
                throw new InAccessibleMethodException();
            }
            call_user_func([$this, "set$name"], $value);
        }

        /**
         * Checks whether a property is set or not.
         *
         * @param string $name The name of the property.
         *
         * @return boolean True when the property is set of false otherwise.
         */
        public function __isset($name) {
            return method_exists($this, "get$name") || method_exists($this, "set$name");
        }

        /**
         * Fills the object with properties.
         *
         * @param array $properties An associative array whose keys are the name and values are the values of the properties.
         */
        public function fill(array $properties) {
            foreach ($properties as $name => $value) {
                $this->__set($name, $value);
            }
        }
    }
}