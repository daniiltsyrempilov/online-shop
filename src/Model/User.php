<?php
namespace Model;

class User extends Model
{
    public function setData(array $post): bool
    {
        $name = $post['name'];
        $email = $post['email'];

        $password = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        $statement = $this->pdo->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
        return $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getOneByEmail(array $val): mixed
    {
        $email = $val['email'];

        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        return $statement->fetch();
    }
}