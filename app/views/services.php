<?php $this->layout('userbase', ['title' => 'Serviços Mundo Pet']) ?>

<?php $this->start('css') ?>
<link rel="stylesheet" href="../css/servicos.css">
<?php $this->stop() ?>

<?php $this->start('main-content') ?>

<div id="container">
    <div class="cards">
        <div class="card">
            <img src="../img/banho.png">
            <div>
                <a href="agendamentos/create">
                    <h3>Banho e Tosa</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
        <div class="card">
            <img src="../img/vacinação.png">
            <div>
                <a href="agendamentos/create">
                    <h3>Vacinação</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
        <div class="card">
            <img src="../img/consulta.png">
            <div>
                <a href="agendamentos/create">
                    <h3>Consulta Veterinária</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <img src="../img/adestramento.png">
            <div>
                <a href="agendamentos/create">
                    <h3>Adestramento</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
        <div class="card">
            <img src="../img/dogWalter.png">
            <div>
                <a href="agendamentos/create">
                    <h3>Dog Walter</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
        <div class="card">
            <img src="../img/store.png">
            <div>
                <a href="catalog">
                    <h3>Lojinha</h3>
                    <img src="../img/icons/click.png">
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        var notification = document.createElement('div');
        notification.className = 'notification';

        notification.innerText = "<?php echo $welcome_message; ?>";
        document.body.appendChild(notification);

        setTimeout(function() {
            notification.style.display = 'none';
        }, 5000);
    }
</script>

<style>
    .notification {
        position: fixed;
        bottom: 10px;
        right: 10px;
        background-color: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        opacity: 0.9;
        z-index: 1000;
    }
</style>
<?php $this->stop() ?>