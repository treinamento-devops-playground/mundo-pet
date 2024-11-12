<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .sidebar {
            flex: 1;
            background-color: #8892BF;
            padding: 20px;
            border-radius: 10px;
            margin-right: 20px;
        }

        .sidebar h3 {
            color: #000000;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #000;
            font-weight: bold;
            display: block;
            padding: 10px;
            background-color: #ccc;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #bbb;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>Administração</h3>
        <ul>
            <li><a href="/admin/agendamentos">Agendamentos</a></li>
            <li><a href="/admin/usuarios">Usuários</a></li>
            <li><a href="/admin/products">Produtos</a></li>
        </ul>
    </div>
</body>