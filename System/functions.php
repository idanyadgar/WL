<?php
namespace {
    use System\App;

    /**
     * Returns the application object.
     *
     * @return App The application object.
     */
    function app() {
        return App::get();
    }

    /**
     * Shortcut to htmlspecialchars().
     *
     * @param string  $string   the string to escape.
     * @param integer $flags    htmlspecialchars flags.
     * @param string  $encoding htmlspecialchars encoding (null for default encoding).
     *
     * @return string the escaped string.
     */
    function e($string, $flags = ENT_QUOTES, $encoding = null) {
        return htmlspecialchars($string, $flags, $encoding == null ? app()->config['encoding'] : $encoding);
    }

    /**
     * Checks whether a controller exists.
     *
     * @param string $controller the name of the controller.
     *
     * @return boolean true if the controller exists or false otherwise.
     */
    function controller_exists($controller) {
        return file_exists(app()->config['root_dir']."/Controllers/$controller.php");
    }

    /**
     * Starts an error page.
     *
     * @param Exception $e the exception which caused the error.
     */
    function errorPage(Exception $e) {
        // TODO: Implement errorPage() function.
    }

    /**
     * An in_array() function which searches for multiple values.
     *
     * @param array $needles  The searched values.
     * @param array $haystack The array to search in.
     *
     * @return boolean True if all the $needles were found in $haystack.
     */
    function in_array_multi(array $needles, array $haystack) {
        return count(array_intersect($needles, $haystack)) == count($needles);
    }

    /**
     * An array_search() function which searches for multiple values.
     *
     * @param array    $needles  The searched values.
     * @param array    $haystack The array to search in.
     * @param boolean  $strict   array_search() <var>$strict</var> parameter.
     *
     * @return array An array whose each <i>element</i> is the key in <var>$haystack</var> whose value equals to the corresponding <i>element</i> in <var>$needles</var>.
     */
    function array_search_multi(array $needles, array $haystack, $strict = false) {
        return array_map(function ($needle) use ($haystack, $strict) {
            return array_search($needle, $haystack, $strict);
        }, $needles);
    }

    /**
     * Checks the type of a value.
     *
     * @param mixed $value The value to checks.
     *
     * @return string The type of the value.
     */
    function get_type($value) {
        $type = gettype($value);
        if ($type == 'object') {
            return get_class($value);
        }
        return $type;
    }

    /**
     * Checks if a method is accessible to a caller.
     *
     * @param string $class  The name of the class.
     * @param string $method The name of the method.
     * @param array  $caller The caller.
     *
     * @return boolean True if <var>$class</var>::<var>$method</var> is accessible to <var>$caller</var>.
     */
    function accessible($class, $method, array $caller) {
        $method = new ReflectionMethod($class, $method);
        if (!$method->isPublic()) {
            if (!array_key_exists('class', $caller)) {
                return false;
            }
            else {
                if ($method->isProtected() && ($caller['class'] != $class && !is_subclass_of($caller['class'], $class))) {
                    return false;
                }
                elseif ($method->isPrivate() && $caller['class'] != $class) {
                    return false;
                }
            }
        }
        return true;
    }
}