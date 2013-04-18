<?php
namespace Controllers {
    use Models\LoginForm;
    use System\Controller;

    /**
     * The Index controller.<br />
     * URL: /Index
     *
     * @package Controllers
     */
    class Index extends Controller {
        /**
         * The Index action.<br />
         * URL: /Index/Index
         */
        public function IndexAction(LoginForm $form, $do = null) {
            $this->viewBag->model = $form;
            if ($do == 'login' && $form->isValid()) {
                echo 'valid.';
            }
            else {
                echo $this->render('form');
            }
        }
    }
}