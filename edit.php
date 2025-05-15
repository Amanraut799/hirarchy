<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $role = $_GET['role'];

    if ($role == "agent") {
        $stmt = $pdo->prepare("SELECT * FROM agents WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    }

    $stmt->bindParam(1, $id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    
    if ($role == "agent") {
        $stmt = $pdo->prepare("UPDATE agents SET fullname = ?, username = ? WHERE id = ?");
    } else {
        $assigned_agent = $_POST["assigned_agent"];
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, username = ?, assigned_agent = ? WHERE id = ?");
        $stmt->bindParam(3, $assigned_agent);
    }

    $stmt->bindParam(1, $fullname);
    $stmt->bindParam(2, $username);
    $stmt->bindParam(4, $id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating record.";
    }
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
    <input type="text" name="fullname" value="<?php echo $data['fullname']; ?>" required><br>
    <input type="text" name="username" value="<?php echo $data['username']; ?>" required><br>

    <?php if ($role != "agent") { ?>
        <select name="assigned_agent">
            <?php
            $agents = $pdo->query("SELECT * FROM agents")->fetchAll();
            foreach ($agents as $agent) {
                $selected = ($agent['id'] == $data['assigned_agent']) ? "selected" : "";
                echo "<option value='{$agent['id']}' $selected>{$agent['fullname']}</option>";
            }
            ?>
        </select><br>
    <?php } ?>

    <button type="submit">Update</button>
</form>