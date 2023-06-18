
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Форма регистрации</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
        }
        
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            padding: 20px;
        }
        
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-container input[type="text"],
        .form-container input[type="password"],
        .form-container input[type="email"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .error-message {
            color: #ff0000;
            margin-bottom: 10px;
        }
        .form-container .login-link a {
            color: #e75d18;
            text-decoration: none;
        }
        
        .form-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Регистрация</h1>
    <form action="обработчик.php" method="POST">
        <label for="login">Логин:</label>
        <input type="text" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <input type="submit" name="register" value="Зарегистрироваться">
    </form>
    
    <div class="login-link">
        <br><a href="loginform.php">У вас уже есть аккаунт? Войти</a>
    </div>
</div>
<?php
// Получение данных из POST-запроса
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];

// Подключение к базе данных
// Проверка уникальности логина
$sqlCheckLogin = "SELECT * FROM $tableName WHERE login='$login'" ;
$result = $conn->query($sqlCheckLogin);

if ($result->num_rows > 0) {
    // Логин уже существует
    $response = array('success' => false, 'message' => 'Такой логин уже занят');
    echo json_encode($response);
    exit(); // Прерывание выполнения скрипта
}

// Проверка уникальности email
$sqlCheckEmail = "SELECT * FROM $tableName WHERE email='$email'";
$result = $conn->query($sqlCheckEmail);

if ($result->num_rows > 0) {
    // Email уже существует
    $response = array('success' => false, 'message' => 'Такой email уже зарегистрирован');
    echo json_encode($response);
    exit(); // Прерывание выполнения скрипта
}

// Выполнение запроса на сохранение данных
$sqlInsertData = "INSERT INTO $tableName (login, email, password) VALUES ('$login', '$email', '$password')";

if ($conn->query($sqlInsertData) === TRUE) {
    // Регистрация успешна
    $response = array('success' => true, 'message' => 'Регистрация успешна');
    echo json_encode($response);
} else {
    // Ошибка при регистрации
    $response = array('success' => false, 'message' => 'Ошибка при регистрации: ' . $conn->error);
    echo json_encode($response);
}

// Закрытие соединения с базой данных
$conn->close();
?>
</body>
</html>
