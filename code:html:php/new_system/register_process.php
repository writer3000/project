<?php
$mysqli = new mysqli('localhost', 'root', '', 'register-bd');

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);
$stmt->execute();

// Отправка письма
$to = $email;
$subject = "Registration Confirmation";
$message = "Thank You for Registering!";
$headers = "From: your_email@example.com";

mail($to, $subject, $message, $headers);

// Редирект на страницу входа
header("Location: login.php");
exit();
?>
