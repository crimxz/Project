<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $user_id = $_SESSION['user_id'];

 
    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $user_id);
    if ($stmt->execute()) {
        echo "Данные обновлены!";
    } else {
        echo "Ошибка при обновлении данных.";
    }
}
?>
