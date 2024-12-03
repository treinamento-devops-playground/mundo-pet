<?php $this->layout('admin-base', ['title' => 'Lista de Agendamentos']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="/css/adminAgendamentos.css">
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>
<div class="content">
    <div class="agendamento-list-section">
        <h2>Lista de Agendamentos</h2>
        <?php if (!empty($agendamentos)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome do Usuário</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr class="agendamento-item">
                            <td><?= htmlspecialchars($agendamento->getUserName()); ?></td>
                            <td><?= htmlspecialchars($agendamento->getServiceType()); ?></td>
                            <td><?= htmlspecialchars($agendamento->getDate()); ?></td>
                            <td><?= htmlspecialchars($agendamento->getTime()); ?></td>
                            <td class="agendamento-actions">
                                <a href="/admin/agendamentos/edit/<?= $agendamento->getId(); ?>" class="edit-btn">Editar</a>
                                
                                <!-- Formulário para exclusão -->
                                <form action="/admin/agendamentos/delete/<?= $agendamento->getId(); ?>" method="POST" style="display: inline;">
                                    <button type="submit" class="delete-btn" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">&#10005;</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum agendamento encontrado.</p>
        <?php endif; ?>
    </div>
    <div class="add-agendamento">
        <a href="/agendamentos/create" class="add-agendamento-btn">Adicionar Agendamento</a>
    </div>
</div>
<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<?php $this->stop(); ?>
