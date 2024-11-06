function displayProducts(products) {
    const productGrid = document.getElementById('product-grid');
    productGrid.innerHTML = '';

    products.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';

        productCard.innerHTML = `
            <a href="../product/${product.id}">
                <img src="../img/logoG.svg" alt="${product.name}" class="product-image">
                <div class="product-name">${product.name}</div>
                <div class="product-description">${product.description}</div>
                <div class="product-price">R$ ${parseFloat(product.price).toFixed(2)}</div>
            </a>
        `;
        productGrid.appendChild(productCard);
    });
}

function fetchProducts(filterType, filterValue) {
    const xhr = new XMLHttpRequest();
    const url = `/product/search`;
    xhr.open('GET', url, true);
    xhr.onload = function () {
        if (this.status === 200) {
            const products = JSON.parse(this.responseText);
            displayProducts(products);
        }
    };
    xhr.send();
}


document.querySelectorAll('.category').forEach(categoryLink => {
    categoryLink.addEventListener('click', function (e) {
        e.preventDefault();
        const category = this.dataset.category;
        fetchProducts('filter', category);
    });
});

document.getElementById('search-btn').addEventListener('click', function () {
    const searchInput = document.getElementById('search-input').value.toLowerCase();
    fetchProducts('search', searchInput);
});

document.addEventListener('DOMContentLoaded', function () {
    fetchProducts('all', '');
});