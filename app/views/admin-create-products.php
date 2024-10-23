<?php $this->layout('admin-base', ['title' => 'Adicionar Produto']); ?>

<?php $this->start('css'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: #f4f4f4;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100vh;
    }

    header {
        width: 100%;
        background-color: #6C5E9C;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    header .logo img {
        height: 50px;
        margin-left: 20px;
    }

    header .list-nav {
        list-style: none;
        display: flex;
        gap: 20px;
        margin-right: 20px;
    }

    header .list-nav li {
        display: inline;
    }

    header .list-nav li a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        padding: 10px 20px;
        transition: background-color 0.3s;
    }

    header .list-nav li a:hover {
        background-color: #575BA7;
        border-radius: 5px;
    }

    main {
        flex: 1;
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .container {
        width: 100%;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }

    .error {
        color: red;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    form label {
        font-weight: 500;
        color: #333;
    }

    form input,
    form textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    form textarea {
        resize: vertical;
    }

    .btn {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>

<body>
    <main>
        <div class="container">
            <h1>Adicionar Produto</h1>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="/admin/products/store">
                <label for="name">Nome do Produto:</label>
                <input type="text" id="name" name="name" required>

                <label for="description">Descrição:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <label for="price">Preço:</label>
                <input type="number" id="price" name="price" step="0.01" required>

                <label for="category">Categoria:</label>
                <input type="text" id="category" name="category" required>

                <label for="stock">Estoque:</label>
                <input type="number" id="stock" name="stock" required>

                <button type="submit" class="btn">Adicionar Produto</button>
            </form>
        </div>
    </main>
</body>

<?php $this->stop(); ?>