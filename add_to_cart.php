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

    // Проверка, существует ли товар с указанным ID
    $query = "SELECT * FROM Products WHERE ProductID = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Добавление товара в корзину
        $query = "INSERT INTO Cart (ProductID, Quantity) VALUES (:id, 1)
                  ON DUPLICATE KEY UPDATE Quantity = Quantity + 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        echo 'Товар добавлен в корзину';
    } else {
        echo 'Товар не найден';
    }
} else {
    echo 'Неверные параметры запроса';
}
?>
