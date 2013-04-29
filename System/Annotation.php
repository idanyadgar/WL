<?php
namespace System {
    use ReflectionClass;
    use ReflectionFunction;
    use ReflectionMethod;
    use ReflectionProperty;
    use Reflector;
    use System\Annotations\Validator;
    use System\Traits\Properties;

    /**
     * Represents an annotation.
     *
     * @package System
     *
     * @property-read string $tag   The tag of the annotation (what follows the @).
     * @property-read string $value The value of the annotation (what follows the tag).
     */
    abstract class Annotation {
        use Properties;

        /**
         * @var array Contains the annotations which have been already retrieved.
         */
        private static $annotations = [
            'classes'    => [],
            'properties' => [],
            'methods'    => [],
            'functions'  => []
        ];
        /**
         * @var string The tag of the annotation (what follows the @).
         */
        protected $_tag;
        /**
         * @var string The value of the annotation (what follows the tag).
         */
        protected $_value;

        /**
         * @param string $value The value of the annotation.
         */
        protected function __construct($value) {
            $tag          = explode('\\', get_class($this));
            $this->_tag   = end($tag);
            $this->_value = $value;
        }

        /**
         * Retrieves the annotations of a given element.
         *
         * @param Reflector $r The reflection object of the element whose annotations are wanted.
         *
         * @return array An array which contains all of the annotations grouped by their tags.
         */
        private static function get(Reflector $r) {
            $doc = $r->getDocComment();
            if (!$doc) {
                return [];
            }
            $annotations = [];
            $doc         = str_replace(
                ["\r\n", "\r"],
                ["\n", "\n"],
                trim(mb_substr($doc, 3, -2))
            );
            preg_match_all('/^\s*\*\s*@([_a-z][_a-z0-9]+)(?:\s+(.*))?\s*$/im', $doc, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                if ($match[1] == 'Validator') {
                    $annotations[$match[1]][] = Validator::getValidator($match[2], $r->getDeclaringClass()->getName(), $r->getName());
                }
                else {
                    $annotation = '\System\Annotations\Unknown';
                    if (class_exists("\\System\\Annotations\\{$match[1]}")) {
                        $annotation = "\\System\\Annotations\\{$match[1]}";
                    }
                    $annotations[$match[1]][] = new $annotation($match[2], $r);
                }
            }
            return $annotations;
        }

        /**
         * Retrieves the annotations of a given class.
         *
         * @param string $class The name of the class.
         *
         * @return array An array which contains all of the annotations grouped by their tags.
         */
        public static function ofClass($class) {
            if (!array_key_exists($class, self::$annotations['classes'])) {
                self::$annotations['classes'][$class] = self::get(new ReflectionClass($class));
            }
            return self::$annotations['classes'][$class];
        }

        /**
         * Retrieves the annotations of a given property.
         *
         * @param string $class    The name of the class.
         * @param string $property The name of the property.
         *
         * @return array An array which contains all of the annotations grouped by their tags.
         */
        public static function ofProperty($class, $property) {
            if (!array_key_exists("$class::$property", self::$annotations['properties'])) {
                self::$annotations['properties']["$class::$property"] = self::get(new ReflectionProperty($class, $property));
            }
            return self::$annotations['properties']["$class::$property"];
        }

        /**
         * Retrieves the annotations of a given class.
         *
         * @param string $class  The name of the class.
         * @param string $method The name of the method.
         *
         * @return array An array which contains all of the annotations grouped by their tags.
         */
        public static function ofMethod($class, $method) {
            if (!array_key_exists("$class::$method", self::$annotations['methods'])) {
                self::$annotations['methods']["$class::$method"] = self::get(new ReflectionMethod($class, $method));
            }
            return self::$annotations['methods']["$class::$method"];
        }

        /**
         * Retrieves the annotations of a given function.
         *
         * @param string $function The name of the function.
         *
         * @return array An array which contains all of the annotations grouped by their tags.
         */
        public static function ofFunction($function) {
            if (!array_key_exists($function, self::$annotations['functions'])) {
                self::$annotations['functions'][$function] = self::get(new ReflectionFunction($function));
            }
            return self::$annotations['functions'][$function];
        }

        /**
         * Returns the <var>$tag</var> property.
         *
         * @return string The <var>$tag</var> property.
         */
        public function getTag() {
            return $this->_tag;
        }

        /**
         * Returns the <var>$value</var> property.
         *
         * @return string The <var>$value</var> property.
         */
        public function getValue() {
            return $this->_value;
        }
    }
}