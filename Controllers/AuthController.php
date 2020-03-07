<?php
    require("../Models/User.php");
    use \Model\User;
    use \Core\AbstractController;

    class AuthController extends AbstractController
    {
        public function login()
        {
            $errors = "";
            // check if form is post
            if (isset($_POST["login"]) && $_POST["password"]){
                $user = new User();
                $login = $user->login($_POST["login"], $_POST["password"]);

                if ($login['is_auth']) {
                    header("Location: /tasks/index");
                } else {
                    $errors = $login['error'];
                }

            }

            $this->render("Auth/login.php", ['errors' => $errors]);
        }
        public function register()
        {
            $user = new User();
            $user->fakeRegister();
            $this->render("Auth/login.php", ['errors' => 'Пользователь admin@admin.com заведен с паролем 123']);
        }

        public function logout()
        {
            $user = new User();
            $user->logout();
            header("Location: /tasks/index");
        }
    }
?>