<?php
// reset_password.php - обработка сброса пароля по токену

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Подключаем конфиг для работы с базой данных
    require_once 'config.php';

    // Проверка существования токена в базе
    $sql = "SELECT * FROM password_resets WHERE token = ? AND created_at > NOW() - INTERVAL 1 HOUR"; // Токен действует 1 час
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Токен существует и действителен, показываем форму для ввода нового пароля
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
            $password = $_POST['password'];

            if (!empty($password)) {
                // Хешируем новый пароль
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Извлекаем email из записи токена
                $row = $result->fetch_assoc();
                $email = $row['email'];

                // Обновляем пароль пользователя в базе
                $sql = "UPDATE users SET password = ? WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $hashedPassword, $email);
                $stmt->execute();

                // Удаляем токен, так как он больше не нужен
                $sql = "DELETE FROM password_resets WHERE token = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $token);
                $stmt->execute();

                echo "Пароль успешно обновлен.";
            } else {
                echo "Пожалуйста, введите новый пароль.";
            }
        }

        // Форма для ввода нового пароля
        echo '
        <form method="POST" action="reset_password.php?token=' . $token . '">
            <input type="password" name="password" placeholder="Введите новый пароль" required>
            <button type="submit">Сбросить пароль</button>
        </form>';
    } else {
        echo "Ссылка для сброса пароля недействительна или истек срок действия.";
    }
} else {
    echo "Недействительный токен.";
}
