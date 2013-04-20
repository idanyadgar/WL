<?php
namespace System {
    use ReflectionProperty;
    use System\Traits\Properties;

    /**
     * The base model class which is inherited by every model in the project.
     *
     * @package System
     *
     * @property-read string[] $errors The array which contains the validation errors.
     */
    abstract class Model {
        use Properties;

        /**
         * @var string[] The array which contains the validation errors.
         */
        private $_errors = [];

        /**
         * Constructs to model.
         */
        public function __construct() {
            $this->_errors = array_fill_keys(array_keys(get_object_vars($this)), '');
            unset($this->_errors['_errors']);
        }

        /**
         * Returns the <var>$errors</var> property.
         *
         * @return string[] The <var>$errors</var> property.
         */
        public function getErrors() {
            return $this->_errors;
        }

        /**
         * Walks over the validation rules of the model and checks each of them with the values of the model.
         *
         * @return boolean true for valid or false otherwise.
         */
        public final function isValid() {
            $valid            = true;
            $defaultValidator = app()->config['default_validator'];
            foreach ($this->errors as $property => $v) {
                $rules = get_validation_rules(new ReflectionProperty($this, $property));
                foreach ($rules as $rule) {
                    if (strpos($rule['method'], '::') === false) {
                        $rule['method'] = "$defaultValidator::{$rule['method']}";
                    }
                    $rule['method']         = 'Validators\\'.$rule['method'];
                    $rule['methodParams'][] = $this->{$property};
                    if (!call_user_func_array($rule['method'], $rule['methodParams'])) {
                        $valid                    = false;
                        $this->_errors[$property] = $rule['errorMessage'];
                        break;
                    }
                }
            }
            return $valid;
        }

        /**
         * Returns the validation error of the wanted <var>$property</var>.
         *
         * @param string $property The name of the wanted property.
         *
         * @return string The error of the specified <var>$property</var>.
         */
        public final function getError($property) {
            return array_key_exists($property, $this->errors) ? $this->errors[$property] : '';
        }
    }
}