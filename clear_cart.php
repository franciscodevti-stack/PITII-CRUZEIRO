<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$session_id = session_id();
$conn->query("DELETE FROM cart WHERE session_id='$username'");
echo json_encode(['success' => true]);
$conn->close();
?>