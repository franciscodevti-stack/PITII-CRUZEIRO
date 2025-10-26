<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

// Verifica se é admin
$user_result = $conn->query("SELECT role FROM users WHERE username='{$_SESSION['username']}'");
$user = $user_result->fetch_assoc();
if ($user['role'] !== 'admin') {
    die('Acesso negado. Você não é administrador.');
}

// Processa atualização de status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
}

// Lista pedidos
$result = $conn->query("SELECT o.id, u.username, o.items, o.total, o.status, o.created_at FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Admin - Pedidos</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>Painel de Administração - Pedidos</h1>
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
        <h2>Gerenciar Pedidos</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Status</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['items']; ?></td>
                    <td>R$ <?php echo number_format($row['total'], 2); ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="pendente" <?php if ($row['status'] == 'pendente') echo 'selected'; ?>>Pendente</option>
                                <option value="aprovado" <?php if ($row['status'] == 'aprovado') echo 'selected'; ?>>Aprovado</option>
                                <option value="enviado" <?php if ($row['status'] == 'enviado') echo 'selected'; ?>>Enviado</option>
                                <option value="cancelado" <?php if ($row['status'] == 'cancelado') echo 'selected'; ?>>Cancelado</option>
                            </select>
                            <button type="submit">Atualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>

</html>
<?php $conn->close(); ?>