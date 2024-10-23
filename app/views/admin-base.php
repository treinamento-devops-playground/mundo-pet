<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #D9D9D9;
            display: flex;
            flex-direction: column;
        }

        .admin-layout {
            display: flex;
            flex-direction: column;
        }

        #nav-bar {
            display: flex;
            justify-content: space-between;
            width: 1000px;
            height: 54px;
            background-color: #6C5E9C;
            border-radius: 15px;
            margin: 25px auto;
            padding: 3px 20px;
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
        }

        ul>li>a {
            text-decoration: none;
            color: #000;
            transition: .8s;
        }

        .list-nav li a:hover {
            color: #fff;
        }

        #container {
            display: flex;
            width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
        }

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


        .content {
            flex: 3;
        }

        .user-section {
            background-color: #D9D9D9;
            display: flex;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile-pic img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-info h2 {
            font-size: 18px;
            font-weight: 500;
            color: #000;
            text-align: center;
        }

        .logout-btn {
            background-color: #E54D4D;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #d43f3f;
        }

        .admin-options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            gap: 15px;
        }

        .admin-btn {
            background-color: #8892BF;
            color: #000;
            padding: 20px 90px 18px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .admin-btn:hover {
            background-color: #6C5E9C;
        }
    </style>
    <?= $this->section('css'); ?>
</head>

<body>
    <div class="admin-layout">
        <div id="nav-bar">
            <?php $this->insert('partials/nav-bar'); ?>
        </div>

        <div id="container">
            <?php $this->insert('partials/admin-side-bar'); ?>
            <div class="content">
                <?= $this->section('admin-content'); ?>
            </div>
        </div>
    </div>

    <?= $this->section('js'); ?>
</body>

</html>