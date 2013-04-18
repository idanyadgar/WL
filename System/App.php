<?php
namespace System {
    use ReflectionClass;
    use ReflectionMethod;
    use System\DB\DB;
    use System\Exceptions\BadRequestException;
    use System\Exceptions\NotFoundException;
    use System\Traits\PropertiesTrait;
    use System\Traits\SingletonTrait;

    /**
     * Represents the application.
     *
     * @package System
     *
     * @property-read array      $config     The configuration array of the application.
     * @property-read DB         $db         The default database of the application.
     * @property-read User       $user       The current user.
     * @property-read Request    $request    The request which was sent by the client.
     * @property-read Controller $controller The currently active controller.
     */
    class App {
        use SingletonTrait;
        use PropertiesTrait;

        /**
         * @var array The configuration array of the application.
         */
        private $_config;
        /**
         * @var DB The default database of the application.
         */
        private $_db;
        /**
         * @var User The current user.
         */
        private $_user;
        /**
         * @var Request The request which was sent by the client.
         */
        private $_request;
        /**
         * @var Controller The currently active controller.
         */
        private $_controller;

        private function __construct() {
            $this->_request = new Request(true);
            $this->_config  = include dirname($_SERVER['DOCUMENT_ROOT']).'/System/config.php';
        }

        /**
         * Returns the configuration array of the application.
         *
         * @return array The configuration array of the application.
         */
        public function getConfig() {
            return $this->_config;
        }

        /**
         * Returns the default database of the application.
         *
         * @return DB The default database of the application.
         */
        public function getDB() {
            if (!$this->_db instanceof DB) {
                $this->_db = new DB();
            }
            return $this->_db;
        }

        /**
         * Returns the current user.
         *
         * @return User The current user.
         */
        public function getUser() {
            return $this->_user;
        }

        /**
         * Return the request which was sent by the client.
         *
         * @return Request The request which was sent by the client.
         */
        public function getRequest() {
            return $this->_request;
        }

        /**
         * Returns the currently active controller.
         *
         * @return Controller The currently active controller.
         */
        public function getController() {
            return $this->_controller;
        }

        /**
         * Runs the application.
         *
         * @param string $controller The name controller.
         * @param string $action     The action.
         * @param array  $params     The parameters.
         *
         * @throws NotFoundException   When the controller does not exist or the action does not exist in the controller.
         * @throws BadRequestException When at least one of the action's required parameters is missing.
         */
        public function run($controller, $action, array $params) {
            $this->init();
            if (!controllerExists($controller) || !method_exists($controller = "\\Controllers\\$controller", $action)) {
                throw new NotFoundException();
            }
            $this->_controller = new $controller;
            $action            = new ReflectionMethod($controller, $action);
            $parameters        = [];
            foreach ($action->getParameters() as $param) {
                if (array_key_exists($param->getName(), $params)) {
                    $parameters[] = $params[$param->getName()];
                }
                elseif ($param->isDefaultValueAvailable()) {
                    $parameters[] = $param->getDefaultValue();
                }
                else {
                    $paramClass = $param->getClass();
                    if ($paramClass instanceof ReflectionClass) {
                        $paramClassName = $paramClass->getName();
                        $obj            = new $paramClassName;
                        foreach ($paramClass->getProperties() as $property) {
                            if (array_key_exists($property->getName(), $params)) {
                                $obj->{$property->getName()} = $params[$property->getName()];
                            }
                        }
                        $parameters[] = $obj;
                    }
                    else {
                        throw new BadRequestException();
                    }
                }
            }
            $parameters = array_merge($parameters, $params);
            $action->invokeArgs($this->_controller, $parameters);
        }

        /**
         * Does all the things that should have been done in the constructor, but could not be done.
         */
        private function init() {
            //$this->userInit();
        }

        /**
         * Initializes the user property.
         */
        private function userInit() {
            if (Member::verifyCookies()) {
                $this->_user = Member::get(Member::GET_BY_ID, $this->request->cookies['UID']);
            }
            else {
                $this->_user = new Guest();
            }
        }
    }
}