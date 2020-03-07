<?php
    namespace Model;
    use \Config\DB;
    use \Delight\Auth\Auth;
    use \Delight\Auth\InvalidEmailException;
    use \Delight\Auth\InvalidPasswordException;
    use \Delight\Auth\TooManyRequestsException;
    use \Delight\Auth\UserAlreadyExistsException;
    use \Core\AbstractModel;

    class User extends AbstractModel
    {
        private $auth;

        public function __construct()
        {
            $db = new DB();
            $this->auth = new Auth($db->getDb());
        }

        public function login($username, $password)
        {
            // remember user for 1 day;
            $rememberDuration = (int)(60 * 60 * 24);

            try {
                $this->auth->login($username, $password, $rememberDuration);
                return ['is_auth' => true, 'error' => false, ];
            }
            catch (InvalidEmailException $e) {
                return ['is_auth' => false, 'error' => 'Username is not correct', ];
            }
            catch (InvalidPasswordException $e) {
                return ['is_auth' => false, 'error' => 'Password is not correct', ];
            }
            catch (TooManyRequestsException $e) {
                return ['is_auth' => false, 'error' => 'Too many requests', ];
            }
        }

        public function fakeRegister(){
            try {
                $this->auth->register('admin@admin.com', '123');
            }
            catch (InvalidEmailException $e) {
                // die('Invalid email address');
            }
            catch (InvalidPasswordException $e) {
                // die('Invalid password');
            }
            catch (UserAlreadyExistsException $e) {
                // die('User already exists');
            }
            catch (TooManyRequestsException $e) {
                // die('Too many requests');
            }
        }

        public function logout()
        {
            $this->auth->logOut();
        }
    }

?>