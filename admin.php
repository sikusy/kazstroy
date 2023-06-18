<!-- Файл: admin_panel.php -->
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
    if (isset($_POST["submit"])) {
        $login = $_POST["login"];
        $banStatus = $_POST["ban_status"];

        // Обновление статуса блокировки пользователя
        $sql = "UPDATE users SET adm = '$banStatus' WHERE login = '$login'";
        if ($conn->query($sql) === TRUE) {
            echo "Статус блокировки пользователя успешно обновлен.";
        } else {
            echo "Ошибка при обновлении статуса блокировки: " . $conn->error;
        }
    } elseif (isset($_POST["delete_submit"])) {
        $login = $_POST["delete_login"];

        // Удаление пользователя
        $sql = "DELETE FROM users WHERE login = '$login'";
        if ($conn->query($sql) === TRUE) {
            echo "Пользователь успешно удален.";
        } else {
            echo "Ошибка при удалении пользователя: " . $conn->error;
        }
    } elseif (isset($_POST["edit_submit"])) {
        $oldLogin = $_POST["edit_old_login"];
        $newLogin = $_POST["edit_new_login"];

        // Редактирование логина пользователя
        $sql = "UPDATE users SET login = '$newLogin' WHERE login = '$oldLogin'";
        if ($conn->query($sql) === TRUE) {
            echo "Логин пользователя успешно обновлен.";
        } else {
            echo "Ошибка при обновлении логина пользователя: " . $conn->error;
        }
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Администраторская панель</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .admin-panel {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 6px;
        }

        .admin-panel h1 {
            text-align: center;
            color: #e75d18;
        }

        .admin-panel form {
            display: flex;
            flex-direction: column;
        }

        .admin-panel label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #e75d18;
        }

        .admin-panel input[type="text"],
        .admin-panel select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .admin-panel input[type="submit"] {
            background-color: #e75d18;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .admin-panel input[type="submit"]:hover {
            background-color: #d64f15;
        }
    </style>
</head>
<body>
    <div class="admin-panel">
        <h1>Администраторская панель</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="login">Логин пользователя:</label>
            <input type="text" name="login" placeholder="Логин пользователя">

            <label for="ban_status">Статус блокировки:</label>
            <select name="ban_status">
                <option value="0">Не заблокирован</option>
                <option value="1">Заблокирован</option>
            </select>

            <input type="submit" name="submit" value="Обновить">
        </form>

        <hr>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="delete_login">Удалить пользователя:</label>
            <input type="text" name="delete_login" placeholder="Логин пользователя">

            <input type="submit" name="delete_submit" value="Удалить">
        </form>

        <hr>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="edit_old_login">Редактировать логин пользователя:</label>
            <input type="text" name="edit_old_login" placeholder="Старый логин">

            <label for="edit_new_login">Новый логин:</label>
            <input type="text" name="edit_new_login" placeholder="Новый логин">

            <input type="submit" name="edit_submit" value="Редактировать">
        </form>
        <a href="admin_page.html">Назад</a>

    </div>
</body>
</html>
