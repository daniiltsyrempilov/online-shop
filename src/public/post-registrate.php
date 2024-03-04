<?php

$val = $_POST;

function validate(array $data): array
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

                $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');
                $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $statement->execute(['email' => $email]);
                $result = $statement->fetch();

                if (!empty($result)) {
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

        if ($password !== $password_repeat) {
            $errors['psw-repeat'] = 'Пароли не совпадают';
        }
    } else {
        $errors['psw-repeat'] = 'Заполните поле password-repeat';
    }
    return $errors;
}

$errors = validate($_POST);

if (empty($errors)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');
    $statement = $pdo->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    header("Location: /login.php");
}

require_once './registrate.php';









