<?php $this->layout('base', ['title' => 'Feedback da Consulta']); ?>

<?php $this->start('css'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap');

    .container {
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    .container .form-group {
        margin-bottom: 20px;
    }

    .container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    .container select,
    .container textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        resize: vertical;
    }

    .container select:focus,
    .container textarea:focus {
        border-color: #80bdff;
        outline: none;
    }

    .container button {
        width: 100%;
        padding: 14px;
        background-color: #28a745;
        border: none;
        color: #fff;
        font-size: 18px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .container button:hover {
        background-color: #218838;
    }
</style>
<?php $this->stop(); ?>

<?php $this->start('main-content'); ?>
<div class="container">
    <h1>Feedback da Consulta</h1>
    <form id="feedback-form">
        <input type="hidden" name="scheduling_id" value="<?= htmlspecialchars($scheduling_id); ?>">

        <div class="form-group">
            <label for="rating">Avaliação:</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Selecione</option>
                <option value="1">1 - Muito Ruim</option>
                <option value="2">2 - Ruim</option>
                <option value="3">3 - Regular</option>
                <option value="4">4 - Bom</option>
                <option value="5">5 - Excelente</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comment">Comentário:</label>
            <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Deixe seu comentário (opcional)"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar Feedback</button>
    </form>
</div>
<?php $this->stop(); ?>

<?php $this->start('js'); ?>
<script>
    document.getElementById('feedback-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = {
            scheduling_id: document.querySelector('input[name="scheduling_id"]').value,
            user_id: <?= json_encode($_SESSION['user_id'] ?? null) ?>,
            rating: document.getElementById('rating').value,
            comment: document.getElementById('comment').value
        };

        fetch('/api/scheduling-feedback/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(({
                status,
                body
            }) => {
                if (status === 201) {
                    alert('Feedback enviado com sucesso!');
                    window.location.href = '/user/agendamentos';
                } else {
                    alert('Erro ao enviar feedback: ' + body.error);
                }
            })
            .catch(error => {
                console.error('Erro na requisição:', error);
                alert('Erro ao enviar feedback: ' + error.message);
            });
    });
</script>
<?php $this->stop(); ?>