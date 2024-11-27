<?php 

namespace app\services\email;

class CheckoutConfimationEmail extends EmailTemplate
{
    protected function getSubject(array $data): string
    {
        return'Mundopet.com.br';
    }

    protected function getBody(array $data): string
    {
        $cartTotal = $data['total'];
        return "
            <h1> Compra comfirmada </h1> 
            <p> Seu pagamento foi confirmado!! </p>
            <p><strong>total de sua compra</strong> " . htmlspecialchars($cartTotal) . "</p>
            ";
    }
}

?>