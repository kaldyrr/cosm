document.addEventListener('DOMContentLoaded', function () {
    fetchCatalog();
    displayCart();
});

function fetchCatalog() {
    // Загрузка продуктов с сервера и их отображение
    fetch('get_products.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('product-list').innerHTML = data;
        })
        .catch(error => console.error('Ошибка загрузки продуктов:', error));
}

function addToCart(productId) {
    // Отправка запроса на сервер для добавления товара в корзину
    fetch('add_to_cart.php?product_id=' + productId)
        .then(response => response.text())
        .then(data => {
            alert(data);
            displayCart();
        })
        .catch(error => console.error('Ошибка добавления в корзину:', error));
}

function displayCart() {
    // Загрузка содержимого корзины с сервера и его отображение
    fetch('get_cart.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('cart-content').innerHTML = data;
        })
        .catch(error => console.error('Ошибка загрузки корзины:', error));
}

function removeFromCart(productId) {
    // Отправка запроса на сервер для удаления товара из корзины
    fetch('remove_from_cart.php?product_id=' + productId)
        .then(response => response.text())
        .then(data => {
            alert(data);
            displayCart();
        })
        .catch(error => console.error('Ошибка удаления из корзины:', error));
}

function submitOrder(event) {
    event.preventDefault();

    const formData = {
        firstName: document.getElementById('customer-firstname').value,
        lastName: document.getElementById('customer-lastname').value,
        email: document.getElementById('customer-email').value,
        address: document.getElementById('customer-address').value,
    };

    // Отправка запроса на сервер для создания заказа
    fetch('submit_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        // Очистка корзины и обновление отображения
        fetch('clear_cart.php')
            .then(() => displayCart())
            .catch(error => console.error('Ошибка очистки корзины:', error));
    })
    .catch(error => console.error('Ошибка оформления заказа:', error));
}
