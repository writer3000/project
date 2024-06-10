<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'register-bd');
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$reset_token = $_POST['token'];
$user_id = $_SESSION['user_id'];

// Проверка токена для сброса пароля
if ($_SESSION['reset_token'] !== $reset_token) {
    die("Ошибка! Неверный токен для сброса пароля.");
}

$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $password, $user_id);
$stmt->execute();

unset($_SESSION['reset_token']);
unset($_SESSION['user_id']);

echo "Пароль успешно изменен.";
?>
