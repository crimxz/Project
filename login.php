<?php
session_start();
require_once 'config.php';

// Вывод информации о текущей сессии для отладки
if (isset($_SESSION['user_id'])) {
    echo 'User ID: ' . $_SESSION['user_id'] . '<br>';
    echo 'Username: ' . $_SESSION['username'] . '<br>';
    echo 'Is Admin: ' . $_SESSION['is_admin'] . '<br>';
} else {
    echo 'Пользователь не авторизован!<br>';
}

if (isset($_SESSION['user_id'])) {
    header("Location: profile.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_admin'] = $user['is_admin'];

                // Отладка перед редиректом
                echo 'User ID: ' . $_SESSION['user_id'] . '<br>';
                echo 'Username: ' . $_SESSION['username'] . '<br>';
                echo 'Email: ' . $_SESSION['email'] . '<br>';
                echo 'Is Admin: ' . $_SESSION['is_admin'] . '<br>';
                exit;  // Останавливаем выполнение, чтобы увидеть вывод

                if ($user['is_admin'] == 1) {
                    header("Location: admin_panel.php");
                } else {
                    header("Location: profile.php");
                }
                exit;
            } else {
                $error = "Неверный пароль!";
            }
        } else {
            $error = "Пользователь не найден!";
        }
    } else {
        $error = "Пожалуйста, заполните все поля!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
    <h2>Вход</h2>
    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <button type="submit" name="login">Войти</button>
    </form>
    <p>Еще нет аккаунта? <a href="auth.php">Зарегистрироваться</a></p>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
</body>
</html>
