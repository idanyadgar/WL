<?php
namespace Models {
    use DateTime;
    use System\Model;

    /**
     * Login model.
     *
     * @package Models
     */
    class RegisterForm extends Model {
        /**
         * @validation-rule Required()    {Username field is required}
         * @validation-rule Length(4, 20) {Username must contain 4 to 20 characters}
         * @display-name    {Username}
         */
        public $username;
        /**
         * @validation-rule Required()   {Password field is required}
         * @validation-rule MinLength(6) {Password must contain at least 6 characters}
         * @display-name    {Password}
         * @attribute       type=password
         */
        public $password;
        /**
         * @validation-rule Compare(&password) {Password and Password confirmation do not match}
         * @display-name    {Confirm Password}
         * @attribute       type=password
         */
        public $rePassword;
        /**
         * @var DateTime
         * @validation-rule Required() {Birthday field is required}
         * @validation-rule Date()     {Invalid date}
         * @display-name    {Birthday}
         * @attribute       type=date
         */
        public $birthday;
        /**
         * @var \System\Enums\Gender
         * @validation-rule Required() {Gender is required}
         * @display-name    {Gender}
         */
        public $gender;
        /**
         * @var \System\Enums\Language[]
         * @validation-rule Required() {At least one language is required}
         * @display-name    {Languages}
         */
        public $languages;
        /**
         * @validation-rule Required(false) {You must agree to the <a href="/Terms">terms of use</a>}
         * @display-text    {I agree to the <a href="/Terms">terms of use</a>}
         */
        public $agree;
    }
}