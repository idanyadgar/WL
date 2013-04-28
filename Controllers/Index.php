<?php
namespace Controllers {
    use Models\RegisterForm;
    use System\Controller;
    use System\View;

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
        public function IndexAction(RegisterForm $form) {
            if (app()->request->method == 'post' && $form->isValid()) {
                $view = new View('show');
            }
            else {
                $view = new View('register');
            }
            $view->model = $form;
            echo $view->render();
        }
    }
}