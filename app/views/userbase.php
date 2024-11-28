<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <?= $this->section('css'); ?>
</head>

<body>
    <div class="container">
        <?php $this->insert('partials/usernav-bar'); ?>
    </div>

    <main class="container">
        <?= $this->section('main-content'); ?>
    </main>

    <?= $this->section('js'); ?>
</body>

</html>