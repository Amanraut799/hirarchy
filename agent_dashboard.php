<?php
session_start();
include 'config.php';

// Ensure agent is logged in
if (!isset($_SESSION["agent_id"])) {
    header("Location: agent_login.php");
    exit();
}

$agent_id = $_SESSION["agent_id"];
$username = $_SESSION["username"];

// Fetch customers assigned to this agent
$customers = $pdo->prepare("SELECT * FROM customers WHERE agent_id = ?");
$customers->bindParam(1, $agent_id);
$customers->execute();
$customer_list = $customers->fetchAll();

// Handle product creation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];

    $stmt = $pdo->prepare("INSERT INTO products (agent_id, product_name, price) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $agent_id);
    $stmt->bindParam(2, $product_name);
    $stmt->bindParam(3, $price);

    if ($stmt->execute()) {
        echo "Product created successfully!";
    } else {
        echo "Error creating product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agent Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?></h2>

    <h3>Customer List:</h3>
    <ul>
        <?php foreach ($customer_list as $customer) {
            echo "<li>{$customer['fullname']} ({$customer['username']})</li>";
        } ?>
    </ul>

    <h3>Generate a New Product</h3>
    <form method="POST">
        <input type="text" name="product_name" placeholder="Product Name" required><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <button type="submit">Create Product</button>
    </form>
</body>
</html>