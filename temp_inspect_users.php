<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
$stmt = $pdo->query('SELECT id, name, email, role, password FROM users');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$rows) {
    echo "NO_USERS\n";
    exit;
}
foreach ($rows as $row) {
    echo $row['id'] . ' | ' . ($row['name'] ?? '') . ' | ' . ($row['email'] ?? '') . ' | ' . ($row['role'] ?? '') . ' | ' . substr($row['password'], 0, 40) . PHP_EOL;
}
