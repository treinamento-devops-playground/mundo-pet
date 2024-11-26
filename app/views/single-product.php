<?php
$requestUri = $_SERVER['REQUEST_URI'];

if (preg_match('/\/product\/(\d+)$/', $requestUri, $matches)) {
    $productId = intval($matches[1]);
} else {
    die("ID do produto não especificado.");
}

try {
    $dbPath = __DIR__ . '/../database/db.db';
    $dsn = 'sqlite:' . $dbPath;
    $pdo = new PDO($dsn);

    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Produto não encontrado.");
    }

    // Consultando avaliações e média de avaliações
    $reviewsStmt = $pdo->prepare('SELECT * FROM review WHERE product_id = :product_id');
    $reviewsStmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $reviewsStmt->execute();
    $reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

    $totalReviews = count($reviews);
    $averageRating = 0;

    if ($totalReviews > 0) {
        $totalRating = 0;
        foreach ($reviews as $review) {
            $totalRating += $review['rating'];
        }
        $averageRating = $totalRating / $totalReviews;
    }
} catch (PDOException $e) {
    die("Não foi possível conectar ao banco de dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Catálogo de Produtos</title>
    <link rel="stylesheet" href="../css/single-product.css">
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
            <li><a href="/vcart"><img src="../img/icons/cart.png" alt="Carrinho"></a></li> 
        </ul>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Pesquisar produtos...">
            <button id="search-btn">
                <img src="../img/icons/lupa.png" alt="Pesquisar" class="search-icon">
            </button>
        </div>
    </header>

    <div class="container">
        <div class="product-details">
            <img src="../img/logoG.svg" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
            <div class="product-description">Descrição: <?php echo htmlspecialchars($product['description']); ?></div>
            <div class="product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></div>
            <div class="product-stock">Estoque: <?php echo htmlspecialchars($product['stock']); ?></div>

            <form action="/cart/add" method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                <button type="submit" class="add-to-cart-btn">Adicionar ao Carrinho</button>
            </form>
        </div>

        <!-- Avaliações -->
        <div class="product-reviews">
            <h3>Avaliações</h3>
            <div class="average-rating">
                <span>Média de Avaliação: <?php echo round($averageRating, 1); ?> / 5</span>
            </div>
            <div class="reviews-list">
                <?php if ($totalReviews > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star previous <?php echo $i <= $review['rating'] ? 'filled' : ''; ?>">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                            <p class="review-date"><?php echo date('d/m/Y', strtotime($review['review_date'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-reviews">Este produto ainda não tem avaliações.</p>
                <?php endif; ?>
            </div>

            <!-- Formulário de avaliação -->
            <div class="review-form">
                <h4>Deixe sua avaliação</h4>
                <div class="rating-stars" id="rating-stars">
                    <span class="star current" data-value="1">&#9733;</span>
                    <span class="star current" data-value="2">&#9733;</span>
                    <span class="star current" data-value="3">&#9733;</span>
                    <span class="star current" data-value="4">&#9733;</span>
                    <span class="star current" data-value="5">&#9733;</span>
                </div>
                <textarea id="review-comment" placeholder="Escreva seu comentário..."></textarea>
                <button id="submit-review" class="submit-review-btn" data-product-id="<?php echo htmlspecialchars($product['id']); ?>">Enviar Avaliação</button>
            </div>
        </div>
    </div>

    <a href="/catalog" class="back-link">Voltar ao Catálogo</a>

</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const starsCurrent = document.querySelectorAll('.star.current');
        const starsPrevious = document.querySelectorAll('.star.previous');
        const commentInput = document.getElementById('review-comment');
        const submitButton = document.getElementById('submit-review');
        const productId = submitButton.getAttribute('data-product-id');
        let rating = 0;

        function updateStars(starElements, rating) {
            starElements.forEach(star => star.classList.remove('filled'));
            for (let i = 0; i < rating; i++) {
                starElements[i].classList.add('filled');
            }
        }

        function setStars(savedRating) {
            if (savedRating > 0) {
                updateStars(starsPrevious, savedRating);
            }
        }

        async function loadProductReviews() {
            try {
                const response = await fetch(`/product/reviews/${productId}`);
                const reviews = await response.json();

                if (reviews.length > 0) {
                    const savedRating = reviews[0].rating;
                    setStars(savedRating);
                }
            } catch (error) {
                console.error('Erro ao carregar avaliações:', error);
            }
        }

        loadProductReviews();

        starsCurrent.forEach(star => {
            star.addEventListener('click', () => {
                rating = parseInt(star.getAttribute('data-value'));
                updateStars(starsCurrent, rating);
            });
        });

        submitButton.addEventListener('click', async () => {
            const comment = commentInput.value;

            if (!rating || !comment) {
                alert('Por favor, preencha a avaliação e o comentário.');
                return;
            }

            try {
                const response = await fetch('/product/review', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ productId, rating, comment })
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Avaliação enviada com sucesso!');
                    location.reload();
                } else {
                    throw new Error(result.message || 'Erro ao enviar a avaliação.');
                }
            } catch (error) {
                alert(error.message);
            }
        });
    });
</script>
