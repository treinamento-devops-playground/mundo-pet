<?php $this->start('css') ?>
<link rel="stylesheet" href="/public/css/agendamento.css">
<?php $this->stop() ?>

<div class="container">
    <div class="container">
        <?php $this->insert('partials/nav-bar'); ?>
    </div>
    <main>
        <div class="form-container">
            <?php echo $this->section('form-content') ?>
        </div>
    </main>
</div>