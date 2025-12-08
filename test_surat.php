<?php
$mysqli = new mysqli('127.0.0.1', 'root', '', 'e-office');
if ($mysqli->connect_error) {
    die('Connect Error: ' . $mysqli->connect_error);
}

echo "=== All Surat Records ===\n";
$result = $mysqli->query('SELECT id_surat, nomor_surat, created_at FROM surat ORDER BY id_surat DESC');
while ($row = $result->fetch_assoc()) {
    echo 'ID: ' . $row['id_surat'] . ', Nomor: ' . $row['nomor_surat'] . ', Created: ' . $row['created_at'] . "\n";
}

$mysqli->close();
?>
