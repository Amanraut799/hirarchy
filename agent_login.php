<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM agents WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($agent && password_verify($password, $agent["password"])) {
        $_SESSION["agent_id"] = $agent["id"];
        $_SESSION["username"] = $agent["username"];
        header("Location: agent_dashboard.php");
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agent Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="agent_login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>