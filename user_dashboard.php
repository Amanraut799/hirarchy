<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// Fetch assigned sales agents
$agents = $pdo->prepare("SELECT * FROM agents WHERE id IN (SELECT assigned_agent FROM users WHERE id = ?)");
$agents->bindParam(1, $user_id);
$agents->execute();
$assigned_agents = $agents->fetchAll();

// Handle customer creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $customer_username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO customers (user_id, fullname, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $fullname);
    $stmt->bindParam(3, $customer_username);
    $stmt->bindParam(4, $password);

    if ($stmt->execute()) {
        echo "Customer created successfully!";
    } else {
        echo "Error creating customer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?></h2>

    <h3>Assigned Sales Agents:</h3>
    <ul>
        <?php foreach ($assigned_agents as $agent) {
            echo "<li>{$agent['fullname']} ({$agent['username']})</li>";
        } ?>
    </ul>

    <h3>Create a New Customer</h3>
    <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Create Customer</button>
    </form>
</body>
</html>