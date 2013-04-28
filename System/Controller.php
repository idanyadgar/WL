<?php
namespace System {
    use ArrayObject;
    use System\Traits\Properties;
    use stdClass;

    /**
     * The base controller class which is inherited by every controller in the project.
     *
     * @package System
     *
     * @property string        $title       The &lt;title&gt; of the page.
     * @property ArrayObject   $keywords    The keywords &lt;meta&gt; tag.
     * @property string        $author      The author &lt;meta&gt; tag.
     * @property string        $description The description &lt;meta&gt; tag.
     * @property ArrayObject   $scripts     Javascript files to include to the page.
     * @property ArrayObject   $styles      Css files to include to the page.
     */
    abstract class Controller {
        use Properties;

        /**
         * @var string The &lt;title&gt; of the page.
         */
        private $_title;
        /**
         * @var ArrayObject The keywords &lt;meta&gt; tag.
         */
        private $_keywords;
        /**
         * @var string The author &lt;meta&gt; tag.
         */
        private $_author;
        /**
         * @var string The description &lt;meta&gt; tag.
         */
        private $_description;
        /**
         * @var ArrayObject Javascript files to include to the page.
         */
        private $_scripts;
        /**
         * @var ArrayObject Css files to include to the page.
         */
        private $_styles;

        public function __construct() {
            $this->_keywords = new ArrayObject();
            $this->_scripts  = new ArrayObject();
            $this->_styles   = new ArrayObject();
        }

        /**
         * Sets &lt;title&gt; of the page.
         *
         * @param string $title The title of the page.
         */
        public function setTitle($title) {
            $this->_title = $title;
        }

        /**
         * Returns &lt;title&gt; of the page.
         *
         * @return string The title of the page.
         */
        public function getTitle() {
            return $this->_title;
        }

        /**
         * Returns the keywords &lt;meta&gt; tag.
         *
         * @return ArrayObject The keywords &lt;meta&gt; tag.
         */
        public function getKeywords() {
            return $this->_keywords;
        }

        /**
         * Sets the author &lt;meta&gt; tag.
         *
         * @param string $author The author &lt;meta&gt; tag.
         */
        public function setAuthor($author) {
            $this->_author = $author;
        }

        /**
         * Returns the author &lt;meta&gt; tag.
         *
         * @return string The author &lt;meta&gt; tag.
         */
        public function getAuthor() {
            return $this->_author;
        }

        /**
         * Sets the description &lt;meta&gt; tag.
         *
         * @param string $description The author &lt;meta&gt; tag.
         */
        public function setDescription($description) {
            $this->_description = $description;
        }

        /**
         * Returns the description &lt;meta&gt; tag.
         *
         * @return string The description &lt;meta&gt; tag.
         */
        public function getDescription() {
            return $this->_description;
        }

        /**
         * Returns the javascript files to include to the page.
         *
         * @return ArrayObject The javascript files to include to the page.
         */
        public function getScripts() {
            return $this->_scripts;
        }

        /**
         * Returns the css files to include to the page.
         *
         * @return ArrayObject The css files to include to the page.
         */
        public function getStyles() {
            return $this->_styles;
        }

        /**
         * Adds a javascript file to include to the page.
         *
         * @param string $script The url of the script.
         */
        public function addScript($script) {
            if (!in_array($script, (array)$this->scripts, true)) {
                $this->scripts[] = $script;
            }
        }

        /**
         * Adds a css file to include to the page.
         *
         * @param string $style The url of the style.
         */
        public function addStyle($style) {
            if (!in_array($style, (array)$this->styles, true)) {
                $this->styles[] = $style;
            }
        }
    }
}