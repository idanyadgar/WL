<?php
namespace System\Annotations {
    use ReflectionClass;
    use System\Annotation;

    /**
     * Validator annotation.
     *
     * @package System\Annotations
     *
     * @property-read string $errorMessage The error message of the validator.
     */
    abstract class Validator extends Annotation {
        /**
         * @var string The error message of the validator.
         */
        protected $_errorMessage;
        /**
         * @var string The name of the property which has the validator.
         */
        protected $property;
        /**
         * @var string The parameters which the validator received.
         */
        private $_params;
        /**
         * @var string The name of the class in which the property which has the validator is.
         */
        private $_className;
        /**
         * @var array
         */
        private static $_temp = [
            'params'    => '',
            'value'     => '',
            'property'  => '',
            'className' => ''
        ];

        public function __construct() {
            parent::__construct(self::$_temp['value']);
            $this->_params    = self::$_temp['params'];
            $this->property   = self::$_temp['property'];
            $this->_className = self::$_temp['className'];
            self::$_temp      = [
                'params'    => '',
                'value'     => '',
                'property'  => '',
                'className' => ''
            ];
        }

        /**
         * Returns the error message.
         *
         * @return string The error message.
         */
        public function getErrorMessage() {
            return $this->_errorMessage = $this->parseErrorMessage($this->_errorMessage);
        }

        /**
         * Does the validation.
         *
         * @param object $object The object in which the checked property is.
         *
         * @return boolean True for success or false otherwise.
         */
        public abstract function validate($object);

        /**
         * Parses an error message.
         *
         * @param string $errorMessage The error message.
         *
         * @return string The parsed error message.
         */
        protected function parseErrorMessage($errorMessage) {
            $params      = $this->_params;
            $annotation  = Annotation::ofProperty($this->_className, $this->property);
            $displayName = array_key_exists('DisplayName', $annotation) ? $annotation['DisplayName'][0]->value : $this->property;
            array_unshift($params, $displayName);
            return preg_replace_callback('/\{(\d+)\}/', function ($matches) use ($params) {
                return array_key_exists($matches[1], $params) ? $params[$matches[1]] : "{{$matches[1]}}";
            }, $errorMessage);
        }

        /**
         * Returns a validator that matches a value of an annotation.
         *
         * @param string $value     The value of the annotation.
         * @param string $className The name of the class in which the property which has the validation is.
         * @param string $property  The name of the property which has the validator.
         *
         * @return Validator The validator.
         */
        public static function getValidator($value, $className, $property) {
            preg_match_all('/^\s*([a-z_][a-z_0-9]+)\((.*|)\)\s*$/i', $value, $matches, PREG_SET_ORDER);
            $matches   = $matches[0];
            $params    = array_map(function ($param) {
                $param = trim($param);
                $lower = strtolower($param);
                if ($lower == 'null') {
                    return null;
                }
                if (in_array($lower, ['true', 'false'])) {
                    return $lower == 'true';
                }
                if (is_numeric($param)) {
                    return strpos($param, '.') == -1 ? intval($param) : floatval($param);
                }
                if (mb_substr($param, 0, 1) == mb_substr($param, -1) && in_array(mb_substr($param, 0, 1), ['"', '\''])) {
                    return mb_substr($param, 1, -1);
                }
                return null;
            }, explode(',', $matches[2]));
            $validator = '\System\Annotations\Validators\Unknown';
            if (class_exists("\\System\\Annotations\\Validators\\{$matches[1]}")) {
                $validator = "\\System\\Annotations\\Validators\\{$matches[1]}";
            }
            self::$_temp = [
                'params'    => $params,
                'value'     => $value,
                'property'  => $property,
                'className' => $className
            ];
            return (new ReflectionClass($validator))->newInstanceArgs($params);
        }
    }
}