<?php
namespace Models {
    use System\Model;

    /**
     * Login model.
     *
     * @package Models
     */
    class RegisterForm extends Model {
        /**
         * @Validator   Required(false, "{0} must be selected")
         * @Validator   Length(4, 20)
         * @DisplayName Username
         */
        public $username;
        /**
         * @Validator   Required()
         * @Validator   MinLength(6)
         * @DisplayName Password
         * @Attribute   type=password
         */
        public $password;
        /**
         * @Validator    Compare("password")
         * @DisplayName  Confirm Password
         * @Attribute    type=password
         */
        public $rePassword;
        /**
         * @VarType     DateTime
         * @Validator   Required()
         * @Validator   Date()
         * @DisplayName Birthday
         * @Attribute   type=date
         */
        public $birthday;
        /**
         * @VarType     \System\Enums\Gender
         * @Validator   Required()
         * @DisplayName Gender
         */
        public $gender;
        /**
         * @VarType     \System\Enums\Language[]
         * @Validator   Required()
         * @DisplayName Languages
         */
        public $languages;
        /**
         * @Validator   Required(true, 'You must agree to the <a href="/Terms">terms of use</a>')
         * @DisplayText I agree to the <a href="/Terms">terms of use</a>
         */
        public $agree;
    }
}