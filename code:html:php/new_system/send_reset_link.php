<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'register-bd');
$email = $_POST['email'];

$stmt = $mysqli->prepare("SELECT id, name, email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Создание и сохранение токена для сброса пароля в сессию
    $reset_token = bin2hex(random_bytes(32)); // Генерация токена для сброса пароля
    $_SESSION['reset_token'] = $reset_token;
    $_SESSION['user_id'] = $user['id'];

    // Отправка письма с ссылкой для сброса пароля
    $reset_link = "http://ваш_сайт/reset_password.php?token=$reset_token";
    $to = $email;
    $subject = "Сброс пароля";
    $message = "Здравствуйте, перейдите по ссылке для сброса пароля: $reset_link";
    $headers = "From: ваш_email@example.com";

    mail($to, $subject, $message, $headers);
    echo "Письмо с инструкциями по сбросу пароля отправлено на вашу почту.";
} else {
    echo "Пользователь с этим email не найден.";
}
?>
