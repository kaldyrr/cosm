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

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Проверка, существует ли товар с указанным ID в корзине
    $query = "SELECT * FROM Cart WHERE ProductID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // Удаление товара из корзины
        $query = "DELETE FROM Cart WHERE ProductID = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        echo 'Товар удален из корзины';
    } else {
        echo 'Товар не найден в корзине';
    }
} else {
    echo 'Неверные параметры запроса';
}
?>
