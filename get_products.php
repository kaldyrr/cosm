<?php
// Подключение к базе данных
$host = 'localhost';
$db = 'kurs';
$user = 'root';
$pass = '123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

// Получение списка продукции
$query = "SELECT * FROM Products";
$products = $pdo->query($query);

foreach ($products as $product) {
    echo '<div class="product-card">';
    echo '<h3>' . $product['ProductName'] . '</h3>';
    echo '<p>Цена: ' . $product['Price'] . ' руб.</p>';
    echo '<button onclick="addToCart(' . $product['ProductID'] . ')">Добавить в корзину</button>';
    echo '</div>';
}
?>
