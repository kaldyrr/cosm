<?php 
$host = 'localhost';
$db = 'kurs';
$user = 'root';
$pass = '123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}
// Получение списка товаров в корзине
$query = "SELECT c.ProductID, p.ProductName, p.Price, c.Quantity FROM Cart c
          JOIN Products p ON c.ProductID = p.ProductID";
$cartItems = $pdo->query($query);

foreach ($cartItems as $item) {
    echo '<div class="cart-item">';
    echo '<h4>' . $item['ProductName'] . '</h4>';
    echo '<p>Цена: ' . $item['Price'] . ' руб.</p>';
    echo '<p>Количество: ' . $item['Quantity'] . '</p>';
    echo '<button onclick="removeFromCart(' . $item['ProductID'] . ')">Убрать из корзины</button>';
    echo '</div>';
}
?>
