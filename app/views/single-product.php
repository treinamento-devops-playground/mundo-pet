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
            <li><a href="/user/edit"><img src="../img/icons/user.png" alt="Usuário"></a></li>
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
                <span>Média de Avaliação: <span id="average-rating">Carregando...</span> / 5</span>
            </div>
            <div class="reviews-list" id="reviews-list">
                <!-- As avaliações serão carregadas aqui -->
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
        const reviewsList = document.getElementById('reviews-list');
        const averageRatingElem = document.getElementById('average-rating');
        const commentInput = document.getElementById('review-comment');
        const submitButton = document.getElementById('submit-review');
        const productId = submitButton.getAttribute('data-product-id');
        let rating = 0;

        // Função para atualizar as estrelas
        function updateStars(starElements, rating) {
            starElements.forEach(star => star.classList.remove('filled'));
            for (let i = 0; i < rating; i++) {
                starElements[i].classList.add('filled');
            }
        }

        // Carregar as avaliações do produto via API
        async function loadProductReviews() {
            try {
                const response = await fetch(`/reviews/${productId}`);  // A URL correta para obter avaliações
                const reviews = await response.json();
                
                if (reviews.length > 0) {
                    let totalRating = 0;
                    reviewsList.innerHTML = ''; // Limpar as avaliações existentes antes de adicionar as novas
                    reviews.forEach(review => {
                        const reviewElem = document.createElement('div');
                        reviewElem.classList.add('review');
                        reviewElem.innerHTML = `
                            <div class="review-rating">${'&#9733;'.repeat(review.rating)}</div>
                            <p class="review-comment">${review.comment}</p>
                            <p class="review-date">${new Date(review.review_date).toLocaleDateString()}</p>
                        `;
                        reviewsList.appendChild(reviewElem);
                        totalRating += review.rating;
                    });
                    const averageRating = totalRating / reviews.length;
                    averageRatingElem.textContent = averageRating.toFixed(1);
                } else {
                    reviewsList.innerHTML = '<p class="no-reviews">Este produto ainda não tem avaliações.</p>';
                }
            } catch (error) {
                console.error('Erro ao carregar avaliações:', error);
            }
        }

        // Enviar uma nova avaliação via API
        submitButton.addEventListener('click', async () => {
            const comment = commentInput.value;

            if (!rating || !comment) {
                alert('Por favor, preencha a avaliação e o comentário.');
                return;
            }

            try {
                const response = await fetch('/product/review', {  // A URL correta para enviar a avaliação
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ productId, rating, comment })
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Avaliação enviada com sucesso!');

                    // Adicionar a nova avaliação diretamente ao DOM
                    const reviewElem = document.createElement('div');
                    reviewElem.classList.add('review');
                    reviewElem.innerHTML = `
                        <div class="review-rating">${'&#9733;'.repeat(rating)}</div>
                        <p class="review-comment">${comment}</p>
                        <p class="review-date">${new Date().toLocaleDateString()}</p>
                    `;
                    reviewsList.prepend(reviewElem); // Adiciona no topo da lista de avaliações

                    // Limpar o campo de comentário e reiniciar a classificação
                    commentInput.value = '';
                    updateStars(starsCurrent, 0); // Resetar estrelas
                } else {
                    throw new Error(result.message || 'Erro ao enviar a avaliação.');
                }
            } catch (error) {
                alert(error.message);
            }
        });

        starsCurrent.forEach(star => {
            star.addEventListener('click', () => {
                rating = parseInt(star.getAttribute('data-value'));
                updateStars(starsCurrent, rating);
            });
        });

        loadProductReviews();
    });
</script>

