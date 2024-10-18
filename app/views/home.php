<?php $this->layout('base', ['title' => $title]) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->e($title) ?></title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <div id="container">
        <p class="slogan">
            Mundo Pet!</br>
            O melhor para o seu pet,</br>
            em um clique!!! <img src="./img/icons/click.png">
        </p>
        <div class="buttons">
            <button class="btn btn-primary"><a href="login">Login</a></button>
            <button class="btn btn-second"><a href="register">Cadastrar</a></button>
        </div>
    </div>
</body>

</html>