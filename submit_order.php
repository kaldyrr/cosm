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

// Проверка, что корзина не пуста
$query = "SELECT COUNT(*) FROM Cart";
$count = $pdo->query($query)->fetchColumn();

if ($count > 0) {
    // Получение данных из формы
    $data = json_decode(file_get_contents('php://input'), true);

    // Вставка данных в таблицу Customers
    $query = "INSERT INTO Customers (FirstName, LastName, Email, Address) VALUES (:firstName, :lastName, :email, :address)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':firstName', $data['firstName'], PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $data['lastName'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
    $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
    $stmt->execute();

    // Получение последнего вставленного ID
    $customerId = $pdo->lastInsertId();

    // Вставка данных в таблицу Orders
    $query = "INSERT INTO Orders (CustomerID, OrderDate, TotalAmount, Status) VALUES (:customerId, NOW(), (SELECT SUM(p.Price * c.Quantity) FROM Products p JOIN Cart c ON p.ProductID = c.ProductID), 'Новый')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
    $stmt->execute();

    // Получение последнего вставленного ID заказа
    $orderId = $pdo->lastInsertId();

    // Вставка данных в таблицу OrderDetails
    $query = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity) SELECT :orderId, ProductID, Quantity FROM Cart";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();

    // Очистка корзины
    $query = "DELETE FROM Cart";
    $pdo->query($query);

    echo 'Заказ успешно оформлен';
} else {
    echo 'Корзина пуста. Невозможно оформить заказ.';
}
?>
