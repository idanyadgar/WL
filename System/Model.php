<?php
namespace System {
    use System\Annotations\Validator;
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
        public final function getErrors() {
            return $this->_errors;
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

        /**
         * Sets an error to a given property.
         *
         * @param string $property The name of the property.
         * @param        $error    $error    The error.
         */
        public final function setError($property, $error) {
            $this->_errors[$property] = $error;
        }

        /**
         * Walks over the validation rules of the model and checks each of them with the values of the model.
         *
         * @return boolean true for valid or false otherwise.
         */
        public final function isValid() {
            $valid = true;
            foreach ($this->errors as $property => $v) {
                $validators = Annotation::ofProperty(get_class($this), $property);
                $validators = array_key_exists('Validator', $validators) ? $validators['Validator'] : [];
                foreach ($validators as $validator) {
                    if (!$validator->validate($this)) {
                        $valid = false;
                        $this->setError($property, $validator->getErrorMessage());
                        break;
                    }
                }
            }
            return $valid;
        }
    }
}