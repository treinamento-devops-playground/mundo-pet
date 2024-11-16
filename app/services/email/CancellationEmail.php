<?php

namespace app\services\email;

class CancellationEmail extends EmailTemplate
{
    protected function getSubject(array $data): string
    {
        return 'Confirmação de Cancelamento de Agendamento';
    }

    protected function getBody(array $data): string
    {
        $motivo = $data['motivo'] ?? 'Motivo não informado.';
        return "
            <h1>Agendamento Cancelado</h1>
            <p>Seu agendamento foi cancelado com sucesso.</p>
            <p><strong>Motivo do cancelamento:</strong> " . htmlspecialchars($motivo) . "</p>
        ";
    }
}
