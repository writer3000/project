<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'register-bd');
$user_name = $_SESSION['user_name'];

if (isset($_POST['new_name'])) {
    $new_name = $_POST['new_name'];
    $stmt = $mysqli->prepare("UPDATE users SET name = ? WHERE name = ?");
    $stmt->bind_param("ss", $new_name, $user_name);
    $stmt->execute();
    $_SESSION['user_name'] = $new_name; // Обновляем имя в сессии
} elseif (isset($_POST['new_email'])) {
    $new_email = $_POST['new_email'];
    $stmt = $mysqli->prepare("UPDATE users SET email = ? WHERE name = ?");
    $stmt->bind_param("ss", $new_email, $user_name);
    $stmt->execute();
}

// Получаем обновленные данные из базы данных
$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE name = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
}

// Перенаправление на страницу профиля после обновления
header("Location: profile.php");
exit();
?>

