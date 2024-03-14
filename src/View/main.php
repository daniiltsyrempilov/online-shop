<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Каталог товаров</title>
</head>

<body>
<h2>Каталог товаров</h2>
<form action = "/logout" method = "get">
    <button type = "submit">LOGOUT</button>
</form>
<ul class="catalog">

    <?php foreach ($products as $product): ?>
    <form action = "main" method = "post">
        <li class="catalog-item">
            <h3><?php echo $product['name'] ?></h3>
            <img src="<?php echo $product['img_url'] ?>" alt="Изображение товара">
            <p class="price"><?php echo $product['price'] ?> руб</p>
            <p><?php echo $product['description'] ?></p>

            <input type="hidden" name="product_id" id="product_id" required value = "<?php echo $product['id'] ?>">
            <input type="hidden" name="quantity" id="quantity" required value=1>
            <button type="submit" class="registerbtn">+</button>
                </form>

            <form action="/rm-product" method="post">
            <input type="hidden" name="product_id" id="product_id" required value = "<?php echo $product['id'] ?>">
            <input type="hidden" name="quantity" id="quantity" required value=1>
            <button type="submit" class="registerbtn">-</button>
                <form>

        </li>
    </form>
    <?php endforeach; ?>
    <a href="/cart" class="button-cart">Корзина (<?php echo $quantityProducts; ?>)</a>
</ul>
</body>

</html>


<style>
    @import url(https://fonts.googleapis.com/css?family=Oswald:400);

    .button-cart {
        background-color: #04AA6D; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    body {
        font: 16px/1.5 sans-serif;
    }

    h2 {
        padding: 0 5px;

        text-align: center;
    }

    .btn {
        position:relative;
        right:100px;
        left:390px;
        top:-50px;
        bottom:10px;
        height:70px;
        width:110px;
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