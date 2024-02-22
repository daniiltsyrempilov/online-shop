<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRep = $_POST['psw-repeat'];

$nameVer = false;
$emailVer = false;

if (empty($name)) {
    echo 'Name not be empty';
} else {
    $nameVer = true;
}

if (strlen($name) < 2) {
    echo 'the name must contain more than 2 characters';
} else {
    $nameVer = true;
}

if (empty($email)) {
    echo 'Email not be empty';
} else {
    $emailVer = true;
}

if (strlen($email) < 2) {
    echo 'The email must contain more than 2 characters';
} else {
    $emailVer = true;
}

#function testEmail($email) {
#    $check = strpos("/@/", $email);
#    return $check;
#}

#if (testEmail($email) == true) {
#    echo "The email must contain the "/@" symbol";
#} else {
#    $emailVer = true;
#}

if ($nameVer == false && $emailVer == false) {
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=laravel", "root", "root");

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $result = $stmt->fetch();

    print_r($result);
}











