<?php
namespace System {
    use Exception;
    use SplFileObject;

    /**
     * The error log is where the errors are written.
     *
     * @package System
     */
    class ErrorLog {
        /**
         * @var SplFileObject The error log file.
         */
        private $file;
        /**
         * @var array The ErrorLog instance.
         */
        private static $instances = [];

        /**
         * @param string $path The path to the error log.
         */
        private function __construct($path) {
            $this->file = new SplFileObject($path, 'a+');
        }

        /**
         * Returns an instance of the ErrorLog class.
         *
         * @param string $path The path to the error log.<br />
         *                     A new error log will be created if the <var>$path</var> given does not exist.<br />
         *                     Pass <b>null</b> for default path.
         *
         * @return ErrorLog The instance of the ErrorLog class.
         */
        public static function get($path = null) {
            $path = $path == null ? app()->config['error_log_path'] : $path;
            if (array_key_exists($path, self::$instances)) {
                return self::$instances[$path];
            }
            return self::$instances[$path] = new self($path);
        }

        /**
         * Returns the error log object available for reading.
         *
         * @return SplFileObject The error log object (iterator).
         */
        public function read() {
            return $this->file;
        }

        /**
         * Writes an exception into the error log.
         *
         * @param Exception $e The Exception to write into the error log.
         *
         * @return boolean true on success or false on failure.
         */
        public function write(Exception $e) {
            $time = date("d-m-Y H:i:s");
            $msg  = $e->getMessage();
            $file = $e->getFile();
            $line = $e->getLine();
            $code = $e->getCode();
            return !is_null($this->file->fwrite("[$time] - $msg in $file:$line [error_code: $code]\r\n"));
        }

        /**
         * Deletes the contents of the error log.
         *
         * @return boolean true on success or false on failure.
         */
        public function emptyLog() {
            return $this->file->ftruncate(0);
        }
    }
}