<?php
namespace Controller;

use Entity\UserEntity;
use Model\User;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function getRegistrate(): void
    {
        require_once './../View/registrate.php';
    }

    public function postRegistrate(): void
    {
        $errors = $this->validateReg($_POST);

        if (empty($errors)) {
            require_once './../Model/User.php';
            $this->userModel->setData($_POST);

            header('Location: /login');
        }

        require_once './../View/registrate.php';
    }

    private function validateReg(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];

            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должен составлять не меньше 2 символов';
            }
        } else {
            $errors['name'] = 'Заполните поле name';
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 2) {
                $errors['email'] = 'Почта должен составлять не меньше 2 символов';
            } else {
                $str = '@';
                $pos = strpos($email, $str);
                if ($pos === false) {
                    $errors['email'] = 'Почта должен иметь символ @ в строке';
                } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    require_once './../Model/User.php';
                    $userModel = new User();

                    if (!empty($userModel->getOneByEmail($email))) {
                        $errors['email'] = 'Пользователь с таким email уже сущетсвует';
                    }
                }
            }
        } else {
            $errors['email'] = 'Заполните поле email';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];

            if (strlen($password) < 2) {
                $errors['password'] = 'Паролль должен составлять не меньше 2 символов';
            }
        } else {
            $errors['password'] = 'Заполните поле password';
        }

        if (isset($data['psw-repeat'])) {
            $password_repeat = $data['psw-repeat'];
            $password = $data['psw'];

            if ($password !== $password_repeat) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw-repeat'] = 'Заполните поле password-repeat';
        }
        return $errors;
    }

    public function getLogin(): void
    {
        require_once './../View/login.php';
    }

    public function postLogin(array $data): void
    {
        $errors = $this->validateLog($_POST);
        $email = $data['email'];

        if(empty($errors)) {
            require_once './../Model/User.php';
            $user = $this->userModel->getOneByEmail($email);

            $password = $_POST['password'];

            if(empty($user)) {
                $errors['email'] = 'Email or password incorrect';
            } else {
                if(password_verify($password, $user->getPassword())) {
                    session_start();
                    $_SESSION['user_id'] = $user->getId();
                    header('Location: /main');
                } else {
                    $errors['password'] = 'Email or password incorrect';
                }
            }
        }

        require_once './../View/login.php';
    }

    private function validateLog(array $val): array
    {
        $errors = [];

        if(isset($val['email'])) {
            $email = $val['email'];

            if(empty($email)) {
                $errors['email'] = 'Email not be empty';
            } elseif(strlen($email) < 2) {
                $errors['email'] = 'The email must have more than 2 characters';
            } else {
                $res = '';

                for ($i = 0; $i < strlen($email); $i++) {
                    if ($email[$i] === '@') {
                        $res = $res.$email[$i];
                    }
                }
                if (strlen($res) !== 1) {
                    $errors['email'] = 'Email is wrong';
                }
            }

        } else {
            $errors['email'] = 'Email must be fill';
        }

        if(isset($val['password'])) {
            $password = $val['password'];

            if(empty($password)) {
                $errors['password'] = 'Password not be empty';
            } elseif(strlen($password) < 5) {
                $errors['password'] = 'The password must have more than 5 characters';
            }

        } else {
            $errors['password'] = 'Password must be fill';
        }

        return $errors;
    }

    public function logout(): void
    {
        session_start();
        if (session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
        header("Location: /login");
    }
}