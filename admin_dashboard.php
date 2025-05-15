<?php
include 'config.php';

echo "<h3>Users</h3><table border='1'>";
echo "<tr><th>Full Name</th><th>Username</th><th>Assigned Agent</th><th>Action</th></tr>";

$users = $pdo->query("SELECT u.*, a.fullname AS agent_name FROM users u LEFT JOIN agents a ON u.assigned_agent = a.id")->fetchAll();
foreach ($users as $user) {
    echo "<tr>
            <td>{$user['fullname']}</td>
            <td>{$user['username']}</td>
            <td>{$user['agent_name']}</td>
            <td><a href='delete.php?id={$user['id']}'>Delete</a></td>
          </tr>";
}
echo "</table>";

echo "<h3>Sales Agents</h3><table border='1'>";
echo "<tr><th>Full Name</th><th>Username</th><th>Action</th></tr>";

$agents = $pdo->query("SELECT * FROM agents")->fetchAll();
foreach ($agents as $agent) {
    echo "<tr>
            <td>{$agent['fullname']}</td>
            <td>{$agent['username']}</td>
            <td><a href='delete.php?id={$agent['id']}&role=agent'>Delete</a></td>
          </tr>";
}
echo "</table>";
?>