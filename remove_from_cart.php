<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$id = $_POST['id'];
$conn->query("DELETE FROM cart WHERE id=$id");
echo json_encode(['success' => true]);
$conn->close();
?>