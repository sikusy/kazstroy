<!-- Файл: login_form.html -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Форма авторизации</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        h1 {
            text-align: center;
            color: #e75d18;
        }
        
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 6px;
        }
        
        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #e75d18;
        }
        
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-container input[type="text"]:focus,
        .form-container input[type="password"]:focus {
            outline: none;
            border-color: #e75d18;
        }
        
        .form-container input[type="submit"] {
            background-color: #e75d18;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .form-container input[type="submit"]:hover {
            background-color: #d64f15;
        }
        
        .login-link {
            text-align: center;
            margin-top: 10px;
        }
        
        .login-link a {
            color: #e75d18;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Авторизация</h1>
        <form method="POST" action="loginform.php">
            <label for="login">Логин:</label>
            <input type="text" name="login" required  placeholder="Логин">
    
            <label for="password">Пароль:</label>
            <input type="password" name="password" required  placeholder="Пароль">
    
            <input type="submit" name="vhod" value="Войти">
    
            <div class="login-link">
                <a href="form.php">У вас еще нет аккаунта? Зарегистрироваться</a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpdb";

// Создание подключения к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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
        $hashedPassword = $row['password'];
        $isBanned = $row['adm'];
        $storedSalt = $row['salt'];

        // Проверка статуса блокировки пользователя
        if ($isBanned == 1) {
            // Пользователь заблокирован
            echo "Ваш аккаунт заблокирован!";
        } else {
            // Проверка пароля
            if (password_verify($password . $storedSalt, $hashedPassword)) {
                echo "Успешная авторизация!";
                // Выполнение дополнительных действий для обычного пользователя
                // Например, перенаправление на обычную страницу пользователя
                header("refresh:1; url=indexx.html");
                exit;
            } else {
                // Неверный логин или пароль
                echo "Неверный логин или пароль!";
                exit;
            }
            
                // Авторизация успешна
               
        }
    } else {
        // Неверный логин или пароль
        echo "Неверный логин или пароль!";
        exit;
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>
