<?php

class User
{
    public function setData(array $post): bool
    {
        $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');

        $name = $post['name'];
        $email = $post['email'];

        $password = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
        return $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getOneByEmail(array $val): mixed
    {
        $pdo = new PDO("pgsql:host=postgres;port=5432;dbname=laravel", 'root', 'root');

        $email = $val['email'];

        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }
}