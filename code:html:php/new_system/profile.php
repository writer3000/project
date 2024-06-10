<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'register-bd');
$user_name = $_SESSION['user_name'];

$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE name = ?");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h2>Welcome, <?php echo $name; ?>!</h2>
    <p>Your Email: <?php echo $email; ?></p>

    <h3>Edit Profile</h3>
    <form action="update_profile.php" method="post">
        <input type="text" name="new_name" placeholder="New Name">
        <input type="email" name="new_email" placeholder="New Email">
        <input type="submit" value="Update">
    </form>
</body>
</html>
