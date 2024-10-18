<?php $this->layout('base', ['title' => 'Agendamento']) ?>

<div class="container">
    <header class="header">
        <?php $this->insert('partials/nav-bar') ?>
    </header>

    <main>
        <div class="form-container">
            <?php echo $this->section('form-content') ?>
        </div>
    </main>
</div>