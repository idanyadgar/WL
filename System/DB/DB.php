<?php
namespace System\DB {
    use PDO;
    use PDOException;
    use System\Exceptions\DBConnectionException;
    use System\Traits\Properties;

    /**
     * Represents a connection to the database.
     *
     * @package System\DB
     */
    class DB extends PDO {
        use Properties;

        /**
         * Creates the connection with the database.
         *
         * @param string $dsn      PDO <var>$dsn</var> parameter (null for default $dsn).
         * @param string $username PDO <var>$username</var> parameter (null for default $username).
         * @param string $password PDO <var>$password</var> parameter (null for default $password).
         * @param array  $options  PDO <var>$options</var> parameter.
         *
         * @throws DBConnectionException If there was an error.
         */
        public function __construct($dsn = null, $username = null, $password = null, array $options = []) {
            try {
                $dsn      = $dsn == null ? app()->config['db']['dsn'] : $dsn;
                $username = $username == null ? app()->config['db']['username'] : $username;
                $password = $password == null ? app()->config['db']['password'] : $password;
                parent::__construct($dsn, $username, $password, $options);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                throw new DBConnectionException($e->getMessage(), $dsn, $username);
            }
        }
    }
}