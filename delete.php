<?php
include 'config.php';

if (isset($_GET['id']) && isset($_GET['role'])) {
    $id = $_GET['id'];
    $role = $_GET['role'];

    if ($role == "agent") {
        $stmt = $pdo->prepare("DELETE FROM agents WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    }

    $stmt->bindParam(1, $id);
    $stmt->execute();
}
?>
