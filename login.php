<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header('Location: index.php'); // Redireciona após login
            exit;
        } else {
            $message = 'Senha incorreta.';
        }
    } else {
        $message = 'Usuário não encontrado.';
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login - Loja de Cupcakes</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>Login</h1>
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
        <?php if (isset($_SESSION['username'])): ?>
            <p>Você já está logado como <?php echo $_SESSION['username']; ?>. <a href="logout.php">Logout</a></p>
        <?php else: ?>
            <form method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Entrar</button>
            </form>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </main>
</body>

</html>