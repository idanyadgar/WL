<?php
namespace System {
    use Exception;
    use System\Traits\Properties;
    use stdClass;

    /**
     * Represents a view.
     *
     * @package System
     *
     * @property Model         $model    The model.
     * @property-read stdClass $viewBag  The variables which are available in the view.
     * @property-write string  $viewName The view name.
     */
    final class View {
        use Properties;

        /**
         * @var string The view file.
         */
        private $_file;
        /**
         * @var HtmlHelper An Html class object.
         */
        private $_html;
        /**
         * @var Model The model.
         */
        private $_model;
        /**
         * @var stdClass The variables which are available in the view.
         */
        private $_viewBag;

        /**
         * @param string $viewName The view name.
         */
        public function __construct($viewName) {
            $this->viewName = $viewName;
            $this->_viewBag = new stdClass();
            $this->_html    = new HtmlHelper($this);
        }

        /**
         * Sets the model.
         *
         * @param Model $model The model.
         */
        public function setModel($model) {
            $this->_model = $model;
        }

        /**
         * Returns the model.
         *
         * @return Model The model.
         */
        public function getModel() {
            return $this->_model;
        }

        /**
         * Returns the variables which are available in the view.
         *
         * @return stdClass The variables which are available in the view.
         */
        public function getViewBag() {
            return $this->_viewBag;
        }

        /**
         * @param $viewName
         *
         * @throws Exception When the <var>$viewName</var> is invalid or could not be found.
         */
        public function setViewName($viewName) {
            if (!preg_match('/^[a-z\d]+$/iu', $viewName)) {
                throw new Exception("'$viewName' is invalid view name.");
            }
            if (!file_exists(app()->config['root_dir']."/Views/$viewName.php")) {
                throw new Exception("'$viewName' view could not be found.");
            }
            $this->_file = app()->config['root_dir']."/Views/$viewName.php";
        }

        /**
         * Renders the view and returns the outputs.
         *
         * @return string The outputs of the view.
         */
        public function render() {
            $html    = $this->_html;
            $model   = $this->_model;
            $viewBag = $this->_viewBag;
            ob_start();
            $scope = function () use ($html, $model, $viewBag) {
                include func_get_arg(0);
            };
            $scope($this->_file);
            $outputs = ob_get_contents();
            ob_end_clean();
            return $outputs;
        }
    }
}