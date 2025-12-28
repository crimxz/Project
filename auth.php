<?php

require_once 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    if (!empty($username) && !empty($email) && !empty($password)) {
      
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка: " . $conn->error;
        }
    } else {
        echo "Пожалуйста, заполните все поля!";
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

  
    if (!empty($email) && !empty($password)) {
       
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

          
            if (password_verify($password, $user['password'])) {
                echo "Добро пожаловать, " . $user['username'] . "!";
            } else {
                echo "Неверный пароль!";
            }
        } else {
            echo "Пользователь не найден!";
        }
    } else {
        echo "Пожалуйста, заполните все поля!";
    }
}
?>


<h2>Регистрация</h2>
<form method="POST" action="auth.php">
    <input type="text" name="username" placeholder="Имя пользователя" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <button type="submit" name="register">Зарегистрироваться</button>
</form>

<h2>Вход</h2>
<form method="POST" action="auth.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <button type="submit" name="login">Войти</button>
</form>
