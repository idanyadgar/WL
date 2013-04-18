<?php

use System\App;

include dirname($_SERVER['DOCUMENT_ROOT']).'/Sources/password_compat.php';

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
 * Makes only the first characters of a string uppercase.<br />
 * <br />
 * Example:<br />
 * <code>
 *    echo ofuc("hElLo WOrLd"); // Hello world
 * </code>
 *
 * @param string $string the input string.
 *
 * @return string the string with only the first character uppercase.
 */
function ofuc($string) {
    return ucfirst(strtolower($string));
}

/**
 * Checks whether a controller exists.
 *
 * @param string $controller the name of the controller.
 *
 * @return boolean true if the controller exists or false otherwise.
 */
function controllerExists($controller) {
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
 * Chekcs if a method is accessible to a caller.
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

/**
 * Retrieves the doc and parses it into an array.
 *
 * @param ReflectionProperty $property The reflection object.
 *
 * @return array The doc as array. An empty array is returned if the doc cannot be retrieved.
 */
function getValidationRules(ReflectionProperty $property) {
    $doc = $property->getDocComment();
    if (!$doc) {
        return [];
    }
    $doc = str_replace(
        ["\r\n", "\r"],
        ["\n", "\n"],
        trim(mb_substr($doc, 3, -2))
    );
    preg_match_all('/^\s*\*\s*@validation\-rule\s+((?:[a-z_][a-z_0-9]*::)?[a-z_][a-z_0-9]*)\((.+?(?:,.+?)*)?\)(?:\s+\{(.*)\})?\s*$/im', $doc, $matches, PREG_SET_ORDER);
    $rules = [];
    foreach ($matches as $match) {
        $rules[] = [
            'method'       => $match[1],
            'methodParams' => isset($match[2]) && trim($match[2]) != '' ? preg_split('/\s*,\s*/', $match[2]) : [],
            'errorMessage' => isset($match[3]) ? $match[3] : ''
        ];
    }
    return $rules;
}