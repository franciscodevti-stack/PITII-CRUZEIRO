<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        $message = 'Registro bem-sucedido! <a href="login.php">Faça login</a>';
    } else {
        $message = 'Erro: Usuário já existe ou problema no registro.';
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro - Loja de Cupcakes</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <h1>Registro</h1>
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
        <form method="POST">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Registrar</button>
        </form>
        <p><?php echo $message; ?></p>
    </main>
</body>
</html>