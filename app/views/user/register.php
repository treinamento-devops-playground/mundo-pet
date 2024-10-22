<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body>
    <div id="container">
        <h2>Cadastro</h2>
        <form method="POST" action="/register" class="form-container">
            <div class="input-container">
                <input type="text" placeholder="Nome" name="username" required>
            </div>
            <div class="input-container">
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-container">
                <input type="password" placeholder="Senha" name="password" required>
            </div>
            <div class="input-container">
                <input type="text" placeholder="Telefone" name="phone" required>
            </div>
            <div class="button-container">
                <button type="submit" class="btn">Cadastrar</button>
            </div>
        </form>
    </div>
</body>

</html>