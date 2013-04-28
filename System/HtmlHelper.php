<?php
namespace System {
    use ReflectionClass;
    use ReflectionProperty;
    use DateTime;

    /**
     * Helps in rendering html controls in a view.
     *
     * @package System
     */
    class HtmlHelper {
        /**
         * @var View The view which is associated with this helper.
         */
        private $_view;

        /**
         * @param View $view The which is associated with this helper.
         */
        public function __construct(View $view) {
            $this->_view = $view;
        }

        /**
         * Generates an anchor tag for a given action.
         *
         * @param string $text       The text inside the tag.
         * @param string $action     The action.
         * @param string $controller The controller or null for the current controller.
         * @param array  $params     The parameters passed in the query string.
         * @param array  $attributes Additional attributes to the tag.
         *
         * @return string The anchor tag.
         */
        public function actionLink($text, $action, $controller = null, array $params = [], array $attributes = []) {
            if (is_null($controller)) {
                $controller = array_slice(explode('\\', get_class(app()->controller)), -1)[0];
            }
            $text       = e($text);
            $action     = urlencode($action);
            $controller = urlencode($controller);
            $oParams    = count($params) ? '?' : '';
            $oParams .= implode('&', array_map(function ($key, $value) {
                return urlencode($key).'='.urlencode($value);
            }, array_keys($params), $params));
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<a href="/%s/%s%s"%s>%s</a>', $controller, $action, $oParams, $oAttributes, $text);
        }

        /**
         * Returns the value of the <var>$property</var> property of the model as a string.
         *
         * @param string $property The name of the wanted property.
         *
         * @return string The value of the property as a string.
         */
        public function display($property) {
            $propVal = $this->_view->model->{$property};
            if (!is_array($propVal)) {
                $propVal = [$propVal];
            }
            return implode(', ', array_map(function($prop) {
                if ($prop instanceof DateTime) {
                    $prop = $prop->format('Y-m-d');
                }
                return e((string)$prop);
            }, $propVal));
        }

        /**
         * Returns the display name of the <var>$property</var> property of the model.
         *
         * @param string $property The property.
         *
         * @return string The display name of the property.
         */
        public function displayName($property) {
            $text = get_property_display_name(new ReflectionProperty($this->_view->model, $property));
            $text = !is_null($text) ? $text : $property;
            return e($text);
        }

        /**
         * Returns the validation message of the <var>$property</var> property of the model.
         *
         * @param string $property The name of the wanted property.
         *
         * @return string The validation message of the property.
         */
        public function validationMessage($property) {
            return $this->_view->model->getError($property);
        }

        /**
         * Generates a label.
         *
         * @param string $text       The text inside the label.
         * @param string $for        The "for" attribute of the label.
         * @param array  $attributes Additional attributes to the label.
         *
         * @return string The generated label tag.
         */
        public function label($text, $for, array $attributes = []) {
            $text        = e($text);
            $attributes  = $attributes + ['for' => $for];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<label%s>%s</label>', $oAttributes, $text);
        }

        /**
         * Generates a label for a given property.
         *
         * @param string $property   The property.
         * @param array  $attributes Additional attributes to the label.
         *
         * @return string The generated label tag.
         */
        public function labelFor($property, array $attributes = []) {
            $text = get_property_display_name(new ReflectionProperty($this->_view->model, $property));
            $text = !is_null($text) ? $text : $property;
            return $this->label("$text:", $property, $attributes);
        }

        /**
         * Generates a text box.
         *
         * @param string $type       The "type" attribute.
         * @param string $value      The default value of the text box.
         * @param array  $attributes Additional attributes to the text box.
         *
         * @return string The generated text box.
         */
        public function textBox($type = 'text', $value = '', array $attributes = []) {
            $attributes  = ['type' => $type] + $attributes + ['value' => $value];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<input%s />', $oAttributes);
        }

        /**
         * Generates a text box for a given property.
         *
         * @param string $property   The property.
         * @param array  $attributes Additional attributes to the text box.
         *
         * @return string The generated text box.
         */
        public function textBoxFor($property, array $attributes = []) {
            $propAttrs = get_property_attributes(new ReflectionProperty($this->_view->model, $property));
            $type      = array_key_exists('type', $propAttrs) ? $propAttrs['type'] : 'text';
            return $this->textBox($type, $this->_view->model->{$property}, $attributes + $propAttrs + ['name' => $property, 'id' => $property]);
        }

        /**
         * Generates a hidden box.
         *
         * @param string $value      The value of the hidden box.
         * @param array  $attributes Additional attributes to the hidden box.
         *
         * @return string The generated hidden box.
         */
        public function hidden($value = '', array $attributes = []) {
            return $this->textBox('hidden', $value, $attributes);
        }

        /**
         * Generates a hidden box for a given property.
         *
         * @param string      $property   The property.
         * @param array       $attributes Additional attributes to the hidden box.
         *
         * @return string The generated hidden box.
         */
        public function hiddenFor($property, array $attributes = []) {
            return $this->hidden($this->_view->model->{$property}, $attributes);
        }

        /**
         * Generates a text area.
         *
         * @param string $value      The default value of the text area.
         * @param array  $attributes Additional attributes to the text area.
         *
         * @return string The generated text area.
         */
        public function textArea($value = '', array $attributes = []) {
            $value       = e($value);
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<textarea%s>%s</textarea>', $oAttributes, $value);
        }

        /**
         * Generates a text area for a given property.
         *
         * @param string $property   The property.
         * @param array  $attributes Additional attributes to the text area.
         *
         * @return string The generated text area.
         */
        public function textAreaFor($property, array $attributes = []) {
            $propAttrs = get_property_attributes(new ReflectionProperty($this->_view->model, $property));
            return $this->textArea($this->_view->model->{$property}, $attributes + $propAttrs + ['name' => $property, 'id' => $property]);
        }

        /**
         * Generates a radio button.
         *
         * @param string $value      The value of the radio button.
         * @param string $text       The text of the radio button.
         * @param array  $attributes Additional attributes to the radio button.
         *
         * @return string The generated radio button.
         */
        public function radio($value = '', $text = '', array $attributes = []) {
            $attributes  = ['type' => 'radio'] + $attributes + ['value' => $value];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<input%s />%s', $oAttributes, $text);
        }

        /**
         * Generates a group of radio buttons.
         *
         * @param string  $name       The name of each radio button in the group.
         * @param array   $values     Each element of the array is a radio button whose text is the <i>key</i> and value is the <i>value</i>.
         * @param integer $checked    The index of the default checked radio button.
         * @param string  $separator  The separator between the radio buttons.
         * @param array   $attributes Additional attributes to each of the radio buttons.
         *
         * @return string The generated radio buttons group.
         */
        public function radioGroup($name, array $values = [], $checked = -1, $separator = "\n", array $attributes = []) {
            $radios      = [];
            $checked     = intval($checked);
            $attributes  = ['type' => 'radio'] + $attributes + ['name' => $name];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            foreach ($values as $text => $value) {
                $radios[] = sprintf('<input%s value="%s"%s />%s', $oAttributes, e($value), $checked-- == 0 ? ' checked="checked"' : '', $text);
            }
            return implode($separator, $radios);
        }

        /**
         * Generates a group of radio buttons for a given property.
         *
         * @param mixed  $property   The property.
         * @param string $separator  The separator between the radio buttons.
         * @param array  $attributes Additional attributes to each of the radio buttons.
         *
         * @return string The generated radio buttons group. 
         */
        public function radioGroupFor($property, $separator = "\n", array $attributes = []) {
            $ref       = new ReflectionProperty($this->_view->model, $property);
            $propType  = get_property_var_type($ref);
            $propAttrs = get_property_attributes($ref);
            if (is_subclass_of($propType, 'System\\Enums\\Enum')) {
                $values = (new ReflectionClass($propType))->getConstants();
                $checked = array_search($this->_view->model->{$property}, array_values($values));
                return $this->radioGroup($property, $values, $checked === false ? -1 : $checked, $separator, $attributes + $propAttrs);
            }
            $text = get_property_display_text($ref);
            return $this->radio($this->_view->model->{$property}, is_null($text) ? '' : $text, $attributes + $propAttrs + ['name' => $property]);
        }

        /**
         * Generates a checkbox.
         *
         * @param string $value      The value of the radio button.
         * @param string $text       The text of the radio button.
         * @param array  $attributes Additional attributes to the radio button.
         *
         * @return string The generated checkbox.
         */
        public function checkBox($value = '', $text = '', array $attributes = []) {
            $attributes  = ['type' => 'checkbox'] + $attributes + ['value' => $value];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            return sprintf('<input%s />%s', $oAttributes, $text);
        }

        /**
         * Generates a group of checkboxes.
         *
         * @param string  $name       The name of each checkbox in the group.
         * @param array   $values     Each element of the array is a checkbox whose text is the <i>key</i> and value is the <i>value</i>.
         * @param array   $checked    The indexes of the default checked checkboxes.
         * @param string  $separator  The separator between the checkboxes.
         * @param array   $attributes Additional attributes to each of the checkboxes.
         *
         * @return string The generated checkboxes group.
         */
        public function checkBoxGroup($name, array $values = [], array $checked = [], $separator = "\n", array $attributes = []) {
            $radios      = [];
            $attributes  = ['type' => 'checkbox'] + $attributes + ['name' => "{$name}[]"];
            $oAttributes = count($attributes) ? ' ' : '';
            $oAttributes .= implode(' ', array_map(function ($key, $value) {
                return e($key).'="'.e($value).'"';
            }, array_keys($attributes), $attributes));
            $i = 0;
            foreach ($values as $text => $value) {
                $radios[] = sprintf('<input%s value="%s"%s />%s', $oAttributes, e($value), in_array($i++, $checked) ? ' checked="checked"' : '', $text);
            }
            return implode($separator, $radios);
        }

        /**
         * Generates a group of checkboxes for a given property.
         *
         * @param mixed  $property   The property.
         * @param string $separator  The separator between the checkboxes.
         * @param array  $attributes Additional attributes to each of the checkboxes.
         *
         * @return string The generated checkboxes group.
         */
        public function checkBoxGroupFor($property, $separator = "\n", array $attributes = []) {
            $ref       = new ReflectionProperty($this->_view->model, $property);
            $propType  = get_property_var_type($ref);
            $propAttrs = get_property_attributes($ref);
            if (mb_substr($propType, -2) == '[]' && is_subclass_of($propType = mb_substr($propType, 0, -2), 'System\\Enums\\Enum')) {
                $values = (new ReflectionClass($propType))->getConstants();
                return $this->checkBoxGroup($property, $values, array_search_multi((array)$this->_view->model->{$property}, array_values($values)), $separator, $attributes + $propAttrs);
            }
            $text = get_property_display_text($ref);
            $propAttrs = !is_null($this->_view->model->{$property}) ? $propAttrs + ['checked' => 'checked'] : $propAttrs;
            return $this->checkBox($this->_view->model->{$property}, is_null($text) ? '' : $text, $attributes + $propAttrs + ['name' => $property]);
        }
    }
}