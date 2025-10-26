<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'Não logado']);
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$username = $_SESSION['username'];
$user_result = $conn->query("SELECT id FROM users WHERE username='$username'");
$user = $user_result->fetch_assoc();
$user_id = $user['id'];

$cart_result = $conn->query("SELECT * FROM cart WHERE session_id='$username'");
$total = 0;
$items = [];
while ($row = $cart_result->fetch_assoc()) {
    $total += $row['price'] * $row['quantity'];
    $items[] = $row['product_name'] . ' x' . $row['quantity'];
}
$items_str = implode(', ', $items);

if ($total > 0) {
    $conn->query("INSERT INTO orders (user_id, items, total) VALUES ($user_id, '$items_str', $total)");
    $conn->query("DELETE FROM cart WHERE session_id='$username'"); // Limpa carrinho após pedido
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Carrinho vazio']);
}
$conn->close();
?>