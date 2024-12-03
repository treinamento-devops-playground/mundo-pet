<?php $this->layout('userbase', ['title' => 'Mundo Pet Home']) ?>

<?php $this->start('css') ?>
<link rel="stylesheet" href="./css/index.css">
<?php $this->stop() ?>

<?php $this->start('main-content') ?>
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
<?php $this->stop() ?>