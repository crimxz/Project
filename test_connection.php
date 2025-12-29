<?php
// Настройки подключения
$servername = "localhost";  
$username = "root";       
$password = "";            
$dbname = "survey_app";  

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);  // Вывод ошибки, если соединение не удалось
}

echo "Подключение к базе данных успешно!";
$conn->close();  // Закрываем подключение
?>
