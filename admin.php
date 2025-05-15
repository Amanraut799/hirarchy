<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    if ($_POST["role"] == "agent") {
        $stmt = $pdo->prepare("INSERT INTO agents (fullname, username, password) VALUES (?, ?, ?)");
    } else {
        $assigned_agent = $_POST["assigned_agent"];
        $stmt = $pdo->prepare("INSERT INTO users (fullname, username, password, assigned_agent) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(4, $assigned_agent);
    }

    $stmt->bindParam(1, $fullname);
    $stmt->bindParam(2, $username);
    $stmt->bindParam(3, $password);
    
    if ($stmt->execute()) {
        echo "User/Agent created successfully!";
    } else {
        echo "Error creating entry.";
    }
}
?>

<form method="POST">
    <input type="text" name="fullname" placeholder="Full Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    
    <select name="role">
        <option value="user">User</option>
        <option value="agent">Sales Agent</option>
    </select><br>

    <select name="assigned_agent">
        <?php
        $agents = $pdo->query("SELECT * FROM agents")->fetchAll();
        foreach ($agents as $agent) {
            echo "<option value='{$agent['id']}'>{$agent['fullname']}</option>";
        }
        ?>
    </select><br>

    <button type="submit">Create</button>
</form>