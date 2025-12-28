<?php
session_start();
require_once 'config.php'; 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h2>Профиль пользователя</h2>
<form method="POST" action="update_profile.php">
    <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
    <button type="submit" name="update_profile">Обновить профиль</button>
</form>

<a href="logout.php">Выйти</a>
