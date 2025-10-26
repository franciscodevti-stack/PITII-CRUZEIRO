<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$username = $_SESSION['username'];
$result = $conn->query("SELECT * FROM cart WHERE session_id='$username'");
$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $total += $row['price'] * $row['quantity'];
    $items[] = $row['product_name'] . ' x' . $row['quantity'];
}
$items_str = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Carrinho - Loja de Cupcakes</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>Seu Carrinho</h1>
        <nav>
            <a href="index.php">Início</a>
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="login.php">Login</a>
                <a href="register.php">Registro</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['username'])): ?>
                <a href="cart.php">Carrinho</a>
                <span>Olá, <?php echo $_SESSION['username']; ?>!</span>
                <?php
                $role_result = $conn->query("SELECT role FROM users WHERE username='{$_SESSION['username']}'");
                $role = $role_result->fetch_assoc()['role'];
                if ($role == 'admin'): ?>
                    <a href="admin.php">Admin</a>
                <?php endif; ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div id="cart-items">
            <?php
            $result->data_seek(0); // Reset result pointer
            while ($row = $result->fetch_assoc()) {
                echo "<p>{$row['product_name']} - R$ {$row['price']} (Qtd: {$row['quantity']}) <button onclick=\"removeFromCart({$row['id']})\">Remover</button></p>";
            }
            ?>
        </div>
        <p>Total: R$ <span id="total"><?php echo number_format($total, 2); ?></span></p>
        <button onclick="clearCart()">Limpar Carrinho</button>
        <?php if ($total > 0): ?>
            <button onclick="checkout()">Finalizar Pedido</button>
        <?php endif; ?>
    </main>
    <script src="./js/script.js"></script>
</body>

</html>
<?php $conn->close(); ?>