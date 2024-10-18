<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/servicos.css">
</head>

<body>
    <nav id="nav-bar">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo Mundo Pet">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="#">Serviços</a></li>
            <li class="title"><a href="#">Loja</a></li>
            <li class="title"><a href="#">Contato</a></li>
            <li><a href="usuario.php"><img src="../img/icons/user.png"></a></li>
        </ul>
    </nav>

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
                    <a href="catalogo.php">
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

</body>

</html>