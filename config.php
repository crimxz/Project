<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');  
define('DB_PASSWORD', '');     
define('DB_NAME', 'survey_app'); 


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
