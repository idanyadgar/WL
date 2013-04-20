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
        public function IndexAction(LoginForm $form) {
            $this->viewBag->model = $form;
            if (app()->request->method == 'post' && $form->isValid()) {
                echo 'valid.';
            }
            else {
                echo $this->render('form');
            }
        }
    }
}