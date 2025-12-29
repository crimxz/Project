<?php
// forgot_password.php - форма для ввода email

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    if (!empty($email)) {
        // Подключаем конфиг для работы с базой данных
        require_once 'config.php';

        // Проверка существования пользователя в базе
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Если пользователь найден, генерируем токен для сброса пароля
            $token = bin2hex(random_bytes(50));  // Генерация случайного токена

            // Сохраняем токен в базе данных (таблица password_resets)
            $sql = "INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();

            // Отправка письма с ссылкой для сброса пароля
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            mail($email, "Ссылка для восстановления пароля", "Для сброса пароля перейдите по следующей ссылке: $resetLink");

            echo "На ваш email отправлена ссылка для сброса пароля.";
        } else {
            echo "Пользователь с таким email не найден.";
        }
    } else {
        echo "Пожалуйста, введите email.";
    }
}
?>

<form method="POST" action="forgot_password.php">
    <input type="email" name="email" placeholder="Введите ваш email" required>
    <button type="submit">Отправить ссылку для сброса пароля</button>
</form>
