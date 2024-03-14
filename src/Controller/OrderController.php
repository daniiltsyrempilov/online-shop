<?php

namespace Controller;

use Model\Order;
use Model\Product;

class OrderController
{
    private Order $orderModel;
    private Product $product;

    public function __construct()
    {
        $this->orderModel = new Order;
        $this->product = new Product;
    }

    public function getOrder()
    {
        session_start();
        if (!isset($_SESSION['user_id']))
        {
            header('Location: /login');
        }

        require_once './../View/order.php';
    }

    public function postOrder($data): void
    {

        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }


        $errors = $this->validateOrder($data);

        if (empty($errors)) {
            $userId =  $_SESSION['user_id'];

            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $phoneNumder = $data['contactnum'];
            $email = $data['email'];
            $address = $data['address'];

            $this->orderModel->create($firstname, $lastname, $phoneOrder, $email, $address);


            header('location:/orderProduct');

        }

        require_once './../View/order.php';
    }

    private function validateOrder(array $data): array
    {
        $errors = [];

        if (isset($data['firstname'])) {
            $firstname = $data['firstname'];
            if (empty($firstname)) {
                $errors['firstname'] = 'Укажите имя.';
            } elseif (strlen($firstname) < 2) {
                $errors['firstname'] = 'Имя должно содержать более 2 символов.';
            }
        } else {
            $errors['firstname'] = 'Укажите имя.';
        }

        if (isset($data['lastname'])) {
            $lastname = $data['lastname'];
            if (empty($lastname)) {
                $errors['lastname'] = 'Укажите фамилию.';
            } elseif (strlen($lastname) < 2) {
                $errors['lastname'] = 'Фамилия должна содержать более 2 символов.';
            }
        } else {
            $errors['lastname'] = 'Укажите фамилию.';
        }

        if (isset($data['contactnum'])) {
            $phoneOrder = $data['contactnum'];
            if (empty($phoneOrder)) {
                $errors['contactnum'] = 'Введите Номер Телефона.';
            } elseif (strlen($phoneOrder) < 6) {
                $errors['contactnum'] = 'Номер Телефона должен содержать более 6 символов.';
            }
        } else {
            $errors['contactnum'] = 'Введите Номер Телефона.';
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (empty($email)) {
                $errors['email'] = 'Укажите почту.';
            } elseif (strlen($email) < 5) {
                $errors['email'] = 'Имя почты должно быть длиной от 5 символов.';
            } elseif (!strpos($email, '@')) {
                $errors['email'] = 'Введено некорректное имя почты, нет символа @.';
            }
        } else {
            $errors['email'] = 'Укажите почту.';
        }



        return $errors;
    }

}