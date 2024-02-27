<?php

$val = $_POST;

function ValidateUser(array $val): array {
    $errors = [];

    if(isset($val['name'])) {
        $name = $val['name'];
        if(empty($name)) {
            $errors['name'] = 'Name not be empty';
        } elseif(strlen($name) < 2) {
            $errors['name'] = 'The name must have more than 2 characters';
        }
    } else {
        $errors['name'] = 'Name must be fill';
    }

    if(isset($val['email'])) {
        $email = $val['email'];

        if(empty($email)) {
            $errors['email'] = 'Email not be empty';
        } elseif(strlen($email) < 2) {
            $errors['email'] = 'The email must have more than 2 characters';
        } else {
            $res = '';
            for($i = 0; $i < strlen($email); $i++) {
                if($email[$i] === '@') {
                    $res = $res.$email[$i];
                }
            }
            if(strlen($res) !== 1) {
                $errors['email'] = 'Email is wrong';
            }
        }
    } else {
        $errors['email'] = 'Email must be fill';
    }

    if(isset($val['psw'])) {
        $password = $val['psw'];
    } else {
        $errors['psw'] = 'Password must be fill';
    }

    if(isset($val['psw-repeat'])) {
        $passwordRep = $val['psw-repeat'];
    } else {
        $errors['psw-repeat'] = 'Password-repeat must be fill';
    }

    if(empty($password)) {
        $errors['psw'] = 'Password not be empty';
    } elseif(strlen($password) < 5) {
        $errors['psw'] = 'The password must have more than 5 characters';
    } elseif($password !== $passwordRep) {
        $errors['psw-repeat'] = 'Password does not match';
    }

    return $errors;
}

$errors = ValidateUser($val);

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    if($user) {
        $errors['email'] = 'A user with such an email exists';
        $flag = true;
    }

}

if ($flag == false) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    #print_r($result);
}

require_once './registrate.php';









