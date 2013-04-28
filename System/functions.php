<?php

/**
 * Returns the application object.
 *
 * @return App The application object.
 */
use System\App;

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
    return array_map(function($needle) use($haystack, $strict) {
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
 * Retrieves the validation rules and parses it into an array.
 *
 * @param ReflectionProperty $property The property.
 *
 * @return array The rules as array. An empty array is returned if the rules cannot be retrieved.
 */
function get_validation_rules(ReflectionProperty $property) {
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

/**
 * Retrieves the attributes of a given property.
 *
 * @param ReflectionProperty $property The property.
 *
 * @return array The attributes of the property as an array.
 */
function get_property_attributes(ReflectionProperty $property) {
    $doc = $property->getDocComment();
    if (!$doc) {
        return [];
    }
    $doc = str_replace(
        ["\r\n", "\r"],
        ["\n", "\n"],
        trim(mb_substr($doc, 3, -2))
    );
    preg_match_all('/^\s*\*\s*@attribute\s+([a-z]+)\s*=\s*(.+)\s*$/imU', $doc, $matches, PREG_SET_ORDER);
    $attrs = [];
    foreach ($matches as $match) {
        $attrs[$match[1]] = $match[2];
    }
    return $attrs;
}

/**
 * Retrieves the display name of a given property.
 *
 * @param ReflectionProperty $property The property.
 *
 * @return string The display name of the property or null if there is not one.
 */
function get_property_display_name(ReflectionProperty $property) {
    $doc = $property->getDocComment();
    if (!$doc) {
        return null;
    }
    $doc = str_replace(
        ["\r\n", "\r"],
        ["\n", "\n"],
        trim(mb_substr($doc, 3, -2))
    );
    preg_match_all('/^\s*\*\s*@display\-name\s+\{(.+)\}\s*$/imU', $doc, $matches, PREG_SET_ORDER);
    return array_key_exists(0, $matches) && array_key_exists(1, $matches[0]) ? $matches[0][1] : null;
}

/**
 * Retrieves the documented type of a given property.
 *
 * @param ReflectionProperty $property The property.
 *
 * @return string The documented type of the property or null if there is not one.
 */
function get_property_var_type(ReflectionProperty $property) {
    $doc = $property->getDocComment();
    if (!$doc) {
        return null;
    }
    $doc = str_replace(
        ["\r\n", "\r"],
        ["\n", "\n"],
        trim(mb_substr($doc, 3, -2))
    );
    preg_match_all('/^\s*\*\s*@var\s+([^\s]+).*$/im', $doc, $matches, PREG_SET_ORDER);
    return array_key_exists(0, $matches) && array_key_exists(1, $matches[0]) ? $matches[0][1] : null;
}

/**
 * Retrieves the display text of a given property.
 *
 * @param ReflectionProperty $property The property.
 *
 * @return string The display text of the property or null if there is not one.
 */
function get_property_display_text(ReflectionProperty $property) {
    $doc = $property->getDocComment();
    if (!$doc) {
        return null;
    }
    $doc = str_replace(
        ["\r\n", "\r"],
        ["\n", "\n"],
        trim(mb_substr($doc, 3, -2))
    );
    preg_match_all('/^\s*\*\s*@display\-text\s+\{(.+)\}\s*$/imU', $doc, $matches, PREG_SET_ORDER);
    return array_key_exists(0, $matches) && array_key_exists(1, $matches[0]) ? $matches[0][1] : null;
}