<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "У вас нет доступа к этой странице.";
    exit;
}


$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);
?>

<h2>Панель администратора</h2>
<table>
    <tr>
        <th>Имя</th>
        <th>Email</th>
        <th>Действия</th>
    </tr>
    <?php while ($user = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['email']; ?></td>
        <td>
            <a href="delete_user.php?id=<?php echo $user['id']; ?>">Удалить</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
