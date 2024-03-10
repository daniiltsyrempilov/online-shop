<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Корзина</title>
</head>

<body>
<h2>Корзина</h2>
<ul class="catalog">

    <?php foreach ($cart as $product): ?>
        <li class="catalog-item">
            <p><?php echo $product['name'] ?></p>
            <img src="<?php echo $product['img_url'] ?>" alt="Изображение товара">
            <!--                <p class="price">Цена за шт: --><?php //echo $product['price'] ?><!-- руб</p>-->
            <p class="price">Количество: <?php echo $product['quantity'] ?> шт</p>
            <p class="price">Цена: <?php echo $product['sum'] ?> руб</p>
        </li>

    <?php endforeach; ?>

</ul>
<p class="price"><?php echo $notification ?? ""; ?></p>
<p class="price">Итоговая сумма заказа: <?php echo $totalPrice; ?> руб</p>

<button type="submit" class="registerbtn">Купить</button>

<p style="color: black"><?php echo $errors['quantity'] ?? $notification ?? '';?></p>

<form action="/main" method="post">

    <button type="submit" class="btn">Каталог товаров</button>
    <form>
</body>

</html>
<style>
    .btn {
        position:relative;
        right:1px;
        left:0px;
        top:-340px;
        bottom:10px;
        height:70px;
        width:110px;
    }

    body {
        font: 16px/1.5 sans-serif;
    }

    h2 {
        padding: 0 5px;

        text-align: center;
    }

    .catalog {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0;
        padding: 0;

        list-style: none;
    }

    .catalog-item {
        display: block;
        width: 220px;

        margin: 5px;
        padding: 5px;

        text-align: center;

        border: 2px solid #87d4e0;
        border-radius: 20px;
    }

    img {
        max-width: 30%;
    }

    .price {
        margin: 0.5em;
    }

    .accept {
        display: block;
        width: 55%;

        margin: 0.4em auto;
        padding: 0.3em;

        color: #87d4e0;
        font-size: 100%;

        background: #fff;

        border: 2px solid #87d4e0;
        border-radius: 15px;

        cursor: pointer;

        transition: all 600ms ease;
    }

    .catalog-item:hover {
        box-shadow: 0 0 5px 2px rgba(11 144 188 / 50%);
    }

    .accept:hover {
        color: #fff;

        background: #87d4e0;

        transform: scale(1.2);
    }

    .accept:active {
        transform: scale(1.1);
        opacity: 0.7;
    }
</style>