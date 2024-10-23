<?php $this->layout('admin-base', ['title' => 'Lista de Agendamentos']); ?>

<?php $this->start('css'); ?>
<link rel="stylesheet" href="../css/adminAgendamentos.css">
<?php $this->stop(); ?>

<?php $this->start('admin-content'); ?>
<div class="content">
    <div class="agendamento-list-section">
        <h2>Lista de Agendamentos</h2>
        <?php if (!empty($agendamentos)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento): ?>
                        <tr class="agendamento-item">
                            <td><?= htmlspecialchars($agendamento['service_type']); ?></td>
                            <td><?= htmlspecialchars($agendamento['date']); ?></td>
                            <td><?= htmlspecialchars($agendamento['time']); ?></td>
                            <td class="agendamento-actions">
                                <a href="/admin/agendamentos/edit/<?= $agendamento['id']; ?>" class="edit-btn">Editar</a>
                                <button class="delete-btn" onclick="confirmDelete(<?= $agendamento['id']; ?>)">&#10005;</button>
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
<script>
    function confirmDelete(agendamentoId) {
        if (confirm('Tem certeza que deseja excluir este agendamento?')) {
            window.location.href = '/agendamentos/delete/' + agendamentoId;
        }
    }
</script>
<?php $this->stop(); ?>