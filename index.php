<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Онлайн-магазин косметики</title>
</head>
<body>
    <header>
        <h1>Онлайн-магазин косметики</h1>
        <nav>
            <ul>
                <li><a href="#home">Главная</a></li>
                <li><a href="#catalog">Каталог</a></li>
                <li><a href="#order">Оформление заказа</a></li>
            </ul>
        </nav>
    </header>

    <section id="catalog">
        <h2>Каталог продукции</h2>
        <div id="product-list">
            <?php include 'get_products.php'; ?>
        </div>
    </section>

    <section id="cart">
        <h2>Корзина</h2>
        <div id="cart-content">
            <?php include 'get_cart.php'; ?>
        </div>
    </section>
	
	<section id="order">
    <h2>Оформление заказа</h2>
    <form id="order-form" onsubmit="submitOrder(event)">
        <label for="customer-firstname">Имя:</label>
        <input type="text" id="customer-firstname" required>

        <label for="customer-lastname">Фамилия:</label>
        <input type="text" id="customer-lastname" required>

        <label for="customer-email">Email:</label>
        <input type="email" id="customer-email" required>

        <label for="customer-address">Адрес:</label>
        <input type="text" id="customer-address" required>

        <button type="submit">Оформить заказ</button>
    </form>
</section>

    <footer>
        <!-- футер -->
    </footer>

    <script src="script.js"></script>
</body>
</html>
