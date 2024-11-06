<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 1000px;
            height: 54px;
            background-color: #6C5E9C;
            border-radius: 15px;
            margin: 25px auto;
            padding: 3px 20px;
        }

        .logo img {
            height: 40px;
        }

        .list-nav {
            list-style: none;
            display: flex;
            gap: 30px;
            align-items: center;
            font-size: 20px;
            padding-top: 3px;
            font-weight: 900;
            cursor: pointer;
            margin-top: 12px;
        }

        .list-nav>li>a {
            text-decoration: none;
            color: #000;
            transition: 0.8s;
            margin-top: 20px;
        }

        .list-nav>li>a:hover {
            color: #fff;
            transition: 0.8s;
            margin-top: 20px;
        }

        .list-nav img {
            height: 40px;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <nav id="nav-bar">
        <div class="logo">
            <img src="../img/logo.png" alt="Logo Mundo Pet">
        </div>
        <ul class="list-nav">
            <li class="title"><a href="/services">Serviços</a></li>
            <li class="title"><a href="product">Loja</a></li>
            <li class="title"><a href="#">Contato</a></li>
            <li><a href="/vis_agen"><img src="../img/icons/user.png" alt="Usuário"></a></li>
        </ul>
    </nav>
</body>

</html>