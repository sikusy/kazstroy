<!-- Файл: loginform.php -->
<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    // Проверка, является ли пользователь администратором
    if ($login === "admin" && $password === "admin") {
        // Авторизация администратора успешна
        echo "Успешная авторизация администратора!";
        // Выполнение дополнительных действий для администратора
        // Например, перенаправление на административную страницу
        header("refresh:1; url=admin_page.html");
        exit;
    }

    // Запрос к базе данных для получения информации о пользователе
    $sql = "SELECT * FROM users WHERE login = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $isBanned = $row['adm'];

        // Проверка статуса блокировки пользователя
        if ($isBanned == 1) {
            // Пользователь заблокирован
            echo "Ваш аккаунт заблокирован!";
        } else {
            // Проверка пароля
            if (password_verify($password, $storedPassword)) {
                // Авторизация успешна
                echo "Успешная авторизация!";
                // Выполнение дополнительных действий для обычного пользователя
                // Например, перенаправление на обычную страницу пользователя
                header("refresh:1; url=indexx.html");
                exit;
            } else {
                // Неверный логин или пароль
                echo "Неверный логин или пароль!";
            }
        }
    } else {
        // Неверный логин или пароль
        echo "Неверный логин или пароль!";
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>
