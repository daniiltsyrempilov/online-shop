<?php

namespace Controller;

use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;
use Model\Product;

class OrderController
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private Product $productModel;


    public function __construct()
    {
        $this->orderModel = new Order;
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->productModel = new Product();
    }

    public function getOrder()
    {
        require_once './../View/order.php';
    }

    public function rere()
    {
        require_once './../View/orderProduct.php';
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

            $this->orderModel->create($userId, $firstname, $lastname, $phoneNumder, $email, $address);

            $userProducts = $this->userProductModel->getAll();

            $price = $this->totalPrice($_SESSION['user_id']);

            foreach ($userProducts as $product) {
                #$productId = $product['product_id'];
                $quantity = $product['quantity'];
                $orderId = $this->orderModel->getOrderId();
                #$order = $this->orderModel->getByUserId($userId);
                $this->orderProductModel->create($product['product_id'], $product['quantity'], $price, $orderId);
            }


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

        if(empty($data['address'])) {
            $errors['address'] = 'Адрес не должен быть пустым';
        }

        return $errors;
    }

    public function totalPrice($userId): float
    {
        $products = $this->productModel->getAll();
        $userProducts = $this->userProductModel->getAllByUserId($userId);
        $totalPrice = 0;

        foreach ($userProducts as $userProduct) {
            $productOfCart = [];
            foreach ($products as $product) {
                if ($product['id'] === $userProduct['product_id']) {
                    $productOfCart['sum'] = $userProduct['quantity'] * $product['price'];
                    $totalPrice += $productOfCart['sum'];
                }
            }
            $totalAmount = $totalPrice;
        }
        return $totalAmount;
    }

}