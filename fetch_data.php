<?php
include 'config.php';

$output = "<h3>Users</h3><table border='1'>
            <tr><th>Full Name</th><th>Username</th><th>Assigned Agent</th><th>Action</th></tr>";

$users = $pdo->query("SELECT u.*, a.fullname AS agent_name FROM users u LEFT JOIN agents a ON u.assigned_agent = a.id")->fetchAll();
foreach ($users as $user) {
    $output .= "<tr>
                <td>{$user['fullname']}</td>
                <td>{$user['username']}</td>
                <td>{$user['agent_name']}</td>
                <td>
                    <button onclick='editUser({$user['id']})'>Edit</button>
                    <button onclick='deleteUser({$user['id']})'>Delete</button>
                </td>
                </tr>";
}
$output .= "</table>";

$output .= "<h3>Sales Agents</h3><table border='1'>
            <tr><th>Full Name</th><th>Username</th><th>Action</th></tr>";

$agents = $pdo->query("SELECT * FROM agents")->fetchAll();
foreach ($agents as $agent) {
    $output .= "<tr>
                <td>{$agent['fullname']}</td>
                <td>{$agent['username']}</td>
                <td>
                    <button onclick='editAgent({$agent['id']})'>Edit</button>
                    <button onclick='deleteAgent({$agent['id']})'>Delete</button>
                </td>
                </tr>";
}
$output .= "</table>";

echo $output;
?>