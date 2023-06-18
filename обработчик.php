<?php
// Параметры подключения к базе данных
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'wpdb';

// Создание подключения к базе данных
$connection = new mysqli($host, $username, $password, $database);

// Проверка соединения на наличие ошибок
if ($connection->connect_error) {
    die("Ошибка подключения: " . $connection->connect_error);
}

// Извлечение данных из формы регистрации
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$storedSalt = $row['salt'];


// SQL-запрос для вставки данных в таблицу
$sql = "INSERT INTO users (login, email, password) VALUES ('$login', '$email', '$hashedPassword')";

// Выполнение SQL-запроса
if ($connection->query($sql) === TRUE) {
    echo "Данные успешно сохранены";
    header("refresh:1; url=index.html");
    exit;
} else {
    echo "Ошибка: " . $sql . "<br>" . $connection->error;
}

// Закрытие соединения с базой данных
$connection->close();
?>
