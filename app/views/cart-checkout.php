<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="/css/cart-checkout.css">
    
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="/services">Serviços</a></li>
            <li class="title"><a href="/catalog">Loja</a></li>
            <li class="title"><a href="#">Contato</a></li>
            <li><a href="/vis_agen"><img src="../img/icons/user.png" alt="Usuário"></a></li>
        </ul>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button id="search-btn">
                <img src="../img/icons/lupa.png" alt="Pesquisar" class="search-icon">
            </button>
        </div>
    </header>
    <div class="container">
        <div class="form-section">
            <h1>Volte ao carrinho</h1>
            <form action="/checkout/process" method="POST">
                <label for="name">Nome Completo</label>
                <input type="text" id="name" name="name" required>

                <label for="city">Cidade</label>
                <input type="text" id="city" name="city" required>

                <label for="address">Endereço</label>
                <input type="text" id="address" name="address" required>

                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" required>

                <label for="complement">Complemento</label>
                <input type="text" id="complement" name="complement">
            </form>
        </div>

        <div class="payment-section">
            <h1>Pagamento</h1>
            <div class="cards">
                <img src="/img/mastercard.png" alt="MasterCard">
                <img src="/img/visa.png" alt="Visa">
            </div>
            <form action="/checkout/process" method="POST">
                <label for="card_name">Nome no cartão</label>
                <input type="text" id="card_name" name="card_name" required>

                <label for="card_number">Número do cartão</label>
                <input type="text" id="card_number" name="card_number" required>

                <label for="expiration_date">Data de expiração</label>
                <input type="text" id="expiration_date" name="expiration_date" placeholder="MM/AA" required>

                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>

                <div class="summary">
                    <?php
                    $cartTotal = 0;
                    if (isset($_SESSION['user_id'])) {
                        $cartModel = new \app\database\models\CartModel();
                        $cartTotal = $cartModel->getCartTotal($_SESSION['user_id']);
                    }
                    ?>
                    <p>Valor: R$ <?php echo number_format($cartTotal, 2, ',', '.'); ?></p>
                    <p>Desconto: R$ 0,00</p>
                    <p>Total: R$ <?php echo number_format($cartTotal, 2, ',', '.'); ?></p>
                </div>

                <button type="submit" class="btn-finalizar">Finalizar</button>
            </form>
        </div>
    </div>
</body>

</html>