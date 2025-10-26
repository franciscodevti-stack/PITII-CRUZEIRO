<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Não logado']);
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$name = $_POST['name'];
$price = $_POST['price'];
$quantity = intval($_POST['quantity']); // Converte para inteiro
$username = $_SESSION['username'];

$conn->query("INSERT INTO cart (session_id, product_name, price, quantity) VALUES ('$username', '$name', $price, $quantity)");
echo json_encode(['success' => true]);
$conn->close();
?>