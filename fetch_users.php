
<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";  // имя пользователя
$password = "";      // ваш пароль 
$dbname = "survey_app";  // имя  базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Подготовленный запрос
$sql = "SELECT * FROM `users` LIMIT 0, 25"; // запрос для получения первых 25 пользователей
$result = $conn->query($sql);

// Проверка результата
if ($result->num_rows > 0) {
    // Выводим данные каждой строки
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Имя: " . $row["username"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "Пользователи не найдены.";
}

// Закрытие соединения
$conn->close();
?>
