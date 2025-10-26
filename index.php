<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cupcake_db');
if ($conn->connect_error) die('Erro na conexão: ' . $conn->connect_error);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Loja de Cupcakes</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>Bem-vindo à Loja Mundo do Cupcake</h1>
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
            <?php else: ?>
                <span>Faça login para acessar o carrinho.</span>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <h2>NOSSOS CUPCAKES TEMÁTICOS</h2>
        <div class="cupcake-list">
            <?php
            $result = $conn->query("SELECT * FROM products");
            while ($row = $result->fetch_assoc()) {
                $id = $row['id']; // Usado como identificador único
                echo "<div class='cupcake'>
                        <img src='{$row['image_url']}' alt='{$row['name']}'>
                        <h3>{$row['name']}</h3>
                        <p>Preço: R$ {$row['price']}</p>
                        <div class='quantity-controls'>
                            <button onclick=\"changeQuantity('qty-{$id}', -1)\">-</button>
                            <span id='qty-{$id}'>1</span>
                            <button onclick=\"changeQuantity('qty-{$id}', 1)\">+</button>
                        </div>
                        <button onclick=\"addToCart('{$row['name']}', {$row['price']}, getQuantity('qty-{$id}'))\">Adicionar ao Carrinho</button>
                      </div>";
            }
            ?>
        </div>
    </main>
    <script src="./js/script.js"></script>
</body>

</html>
<?php $conn->close(); ?>