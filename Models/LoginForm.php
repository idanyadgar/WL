<?php
namespace Models {
    use System\Model;

    /**
     * Login model.
     *
     * @package Models
     */
    class LoginForm extends Model {
        /**
         * @validation-rule required()           {username field is required}
         * @validation-rule lengthBetween(4, 20) {username must contain 4 to 20 characters}
         */
        public $username;
        /**
         * @validation-rule required() {password field is required}
         */
        public $password;
    }
}