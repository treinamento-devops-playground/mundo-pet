<?php

namespace app\controllers\site;

use app\services\ReviewService;
use Exception;

class ReviewController
{
    private $reviewService;

    public function __construct()
    {
        $this->reviewService = new ReviewService();
    }

    // Adicionar uma nova avaliação
    public function addReview()
    {
        session_start();

        // Verificando se o usuário está autenticado
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401); // Alterado para 401 Unauthorized
            echo json_encode(["message" => "Usuário não autenticado"]);
            exit();
        }

        // Obtendo os dados da requisição
        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['productId'] ?? null;
        $rating = $data['rating'] ?? null;
        $comment = $data['comment'] ?? null;
        $userId = $_SESSION['user_id'];

        // Validação de dados
        if (empty($productId) || empty($rating) || empty($comment)) {
            http_response_code(400); // Validação correta
            echo json_encode(["message" => "Todos os campos são obrigatórios"]);
            exit();
        }

        try {
            // Usando o serviço para adicionar a avaliação
            $result = $this->reviewService->addReview($productId, $userId, $rating, $comment);

            if ($result) {
                echo json_encode(["message" => "Avaliação salva com sucesso!"]);
            } else {
                http_response_code(500); // Erro ao salvar
                echo json_encode(["message" => "Erro ao salvar a avaliação."]);
            }
        } catch (Exception $e) {
            http_response_code(500); // Erro genérico
            echo json_encode(["message" => $e->getMessage()]);
        }
    }

    // Recuperar as avaliações de um produto
    public function getProductReviews($productId)
    {
        try {
            $reviews = $this->reviewService->getProductReviews($productId);

            // Adicionando log para depuração
            error_log(print_r($reviews, true));  // Exibindo o conteúdo das avaliações no log

            // Resposta com as avaliações em formato JSON
            echo json_encode($reviews);
        } catch (Exception $e) {
            http_response_code(500); // Erro ao carregar
            echo json_encode(["message" => "Erro ao carregar avaliações."]);
        }
    }
}
