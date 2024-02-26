<?php

$val = $_POST;

function validateLog(array $val): array {
    $errors = [];

    if(isset($val['email'])) {
        $email = $val['email'];
    } else {
        $errors['email'] = 'Email must be fill';
    }

    if(isset($val['pws'])) {
        $password = $val['pws'];
    } else {
        $errors['pws'] = 'Password must be fill';
    }

    if(empty($email)) {
        $errors['email'] = 'Email not be empty';
    } elseif(strlen($email) < 2) {
        $errors['email'] = 'The email must have more than 2 characters'
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

    if(empty($password)) {
        $errors['pws'] = 'Password not be empty';
    } elseif(strlen($password) < 5) {
        $errors['pws'] = 'The password must have more than 5 characters';
    }
    return $errors;
}

$errors = validateLog($val);

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

    $email = $_POST['email'];
    $password = $_POST['pws'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();

    $access = '';

    if(password_verify($password, $result['password'])) {
        $access = 'Welcome';
    } else {
        $access = 'Password is wrong';
    }
}