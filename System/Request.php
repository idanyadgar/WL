<?php
namespace System {
    use ArrayObject;
    use DateTime;
    use System\Enums\RequestMethod;
    use System\Traits\Properties;

    /**
     * Represents a request which was sent to the server.
     *
     * @package System
     *
     * @property string                    $ip          The internet protocol from which the request was sent.
     * @property string                    $userAgent   The user-agent of the request.
     * @property string                    $protocol    The protocol of the request.
     * @property RequestMethod             $method      The method of the request.
     * @property string                    $queryString The query string of the request.
     * @property string                    $uri         The URI of the request.
     * @property DateTime                  $time        The time of the request.
     * @property-read array                $cookies     The cookies sent in the request.
     * @property-read ArrayObject          $session     The cookies sent in the request.
     */
    class Request {
        use Properties;

        /**
         * @var string The internet protocol from which the request was sent.
         */
        private $_ip;
        /**
         * @var string The user-agent of the request.
         */
        private $_userAgent;
        /**
         * @var string Request protocol.
         */
        private $_protocol;
        /**
         * @var RequestMethod Request method.
         */
        private $_method;
        /**
         * @var string Request query string.
         */
        private $_queryString;
        /**
         * @var string Request URI.
         */
        private $_uri;
        /**
         * @var DateTime The request time.
         */
        private $_time;
        /**
         * @var array The cookies sent in the request.
         */
        private $_cookies;
        /**
         * @var ArrayObject The session of the client.
         */
        private $_session;

        /**
         * @param boolean $current Indicates whether this Request represents the current request or not.
         */
        public function __construct($current) {
            if ($current) {
                $this->ip          = $_SERVER['REMOTE_ADDR'];
                $this->userAgent   = $_SERVER['HTTP_USER_AGENT'];
                $this->protocol    = $_SERVER['SERVER_PROTOCOL'];
                $this->method      = RequestMethod::getFromString($_SERVER['REQUEST_METHOD']);
                $this->queryString = $_SERVER['QUERY_STRING'];
                $this->uri         = $_SERVER['REQUEST_URI'];
                $this->time        = new DateTime('@'.$_SERVER['REQUEST_TIME']);
                $this->_cookies    = $_COOKIE;
                $this->_session    = new ArrayObject($_SESSION, ArrayObject::ARRAY_AS_PROPS);
            }
        }

        /**
         * Returns the IP of the client who sent the request.
         *
         * @return string The IP of the client who sent the request.
         */
        public function getIP() {
            return $this->_ip;
        }

        /**
         * Sets the IP of the client who sent the request.
         *
         * @param string $ip The IP of the client who sent the request.
         */
        public function setIP($ip) {
            $this->_ip = $ip;
        }

        /**
         * Returns the user-agent.
         *
         * @return string The user-agent of the request.
         */
        public function getUserAgent() {
            return $this->_userAgent;
        }

        /**
         * Sets the user-agent.
         *
         * @param string $userAgent The user-agent of the request.
         */
        public function setUserAgent($userAgent) {
            $this->_userAgent = $userAgent;
        }

        /**
         * Returns the request protocol.
         *
         * @return string The request protocol.
         */
        public function getProtocol() {
            return $this->_protocol;
        }

        /**
         * Sets the protocol.
         *
         * @param string $protocol The protocol of the request.
         */
        public function setProtocol($protocol) {
            $this->_protocol = $protocol;
        }

        /**
         * Returns The method of the request.
         *
         * @return RequestMethod The method of the request.
         */
        public function getMethod() {
            return $this->_method;
        }

        /**
         * Sets the request of the method.
         *
         * @param RequestMethod $method The method of the request.
         */
        public function setMethod(RequestMethod $method) {
            $this->_method = $method;
        }

        /**
         * Returns The query string of the request.
         *
         * @return string The query string of the request.
         */
        public function getQueryString() {
            return $this->_queryString;
        }

        /**
         * Sets the query string of the request.
         *
         * @param string $queryString The query string of the request.
         */
        public function setQueryString($queryString) {
            $this->_queryString = $queryString;
        }

        /**
         * Returns The uri of the request.
         *
         * @return string The uri of the request.
         */
        public function getUri() {
            return $this->_uri;
        }

        /**
         * Sets the uri of the request.
         *
         * @param string $uri The uri of the request.
         */
        public function setUri($uri) {
            $this->_uri = $uri;
        }

        /**
         * Returns the time of the request.
         *
         * @return DateTime The time of the request.
         */
        public function getTime() {
            return $this->_time;
        }

        /**
         * Sets the time of the request.
         *
         * @param DateTime $time The time of the request.
         */
        public function setTime(DateTime $time) {
            $this->_time = $time;
        }

        /**
         * Returns the cookies of the request.
         *
         * @return array The cookies of the request.
         */
        public function getCookies() {
            return $this->_cookies;
        }

        /**
         * Returns the session of the client.
         *
         * @return ArrayObject The session of the client.
         */
        public function getSession() {
            return $this->_session;
        }
    }
}