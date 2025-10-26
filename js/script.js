// Função para alterar quantidade
function changeQuantity(qtyId, delta) {
    const qtyElement = document.getElementById(qtyId);
    let qty = parseInt(qtyElement.textContent);
    qty += delta;
    if (qty < 1) qty = 1; // Mínimo 1
    qtyElement.textContent = qty;
}

// Função para obter quantidade
function getQuantity(qtyId) {
    return parseInt(document.getElementById(qtyId).textContent);
}

// Função para adicionar item ao carrinho (agora com quantidade)
async function addToCart(name, price, quantity) {
    try {
        const response = await fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `name=${encodeURIComponent(name)}&price=${price}&quantity=${quantity}`
        });
        const data = await response.json();
        if (data.error) {
            alert('Você precisa fazer login para adicionar ao carrinho.');
            window.location.href = 'login.php';
        } else {
            alert(`${quantity} x ${name} adicionado(s) ao carrinho!`);
        }
    } catch (error) {
        console.error('Erro ao adicionar ao carrinho:', error);
    }
}

// Função para remover item do carrinho (igual ao anterior)
async function removeFromCart(id) {
    try {
        await fetch('remove_from_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        });
        location.reload();
    } catch (error) {
        console.error('Erro ao remover do carrinho:', error);
    }
}

// Função para limpar carrinho (igual ao anterior)
async function clearCart() {
    try {
        await fetch('clear_cart.php', { method: 'POST' });
        location.reload();
    } catch (error) {
        console.error('Erro ao limpar carrinho:', error);
    }
}

// Função para finalizar pedido (igual ao anterior)
async function checkout() {
    try {
        const response = await fetch('checkout.php', { method: 'POST' });
        const data = await response.json();
        if (data.success) {
            alert('Pedido finalizado com sucesso!');
            location.reload();
        } else {
            alert(data.error || 'Erro ao finalizar pedido.');
        }
    } catch (error) {
        console.error('Erro no checkout:', error);
    }
}

// Simulação de login (igual ao anterior)
document.getElementById('login-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    if (username && password) {
        document.getElementById('message').textContent = 'Login bem-sucedido!';
    } else {
        document.getElementById('message').textContent = 'Credenciais inválidas.';
    }
});