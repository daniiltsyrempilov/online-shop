<?php

function ValidateLog(array $val): array {
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

$val = $_POST;
$errors = ValidateLog($val);

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if(!$user) {
        $errors['email'] = 'Email or password incorrect';
    } else {
        if(password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: /main.php");
        } else {
            $errors['password'] = 'Email or password incorrect';
        }
    }
}

require_once 'login.php';