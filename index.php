<?php
session_start();
?>

<h1>Добро пожаловать!</h1>
<p>Привет, <?php echo $_SESSION['username']; ?>! Вы вошли в систему.</p>
