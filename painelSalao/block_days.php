<?php
// block_days.php

require 'config.php';

header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método não permitido.';
    exit;
}

if (!isset($_POST['dias']) || !is_array($_POST['dias'])) {
    http_response_code(400);
    echo 'Dados inválidos.';
    exit;
}

$dates = $_POST['dias'];

// Desativa o autocommit para iniciar a transação
$conn->autocommit(false);

$stmt = $conn->prepare("INSERT IGNORE INTO blocked_days (data_bloqueada) VALUES (?)");
if (!$stmt) {
    http_response_code(500);
    echo "Erro na preparação da query.";
    exit;
}

foreach ($dates as $date) {
    // Valida o formato da data (YYYY-MM-DD)
    if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
        $stmt->bind_param("s", $date);
        if (!$stmt->execute()) {
            $conn->rollback();
            http_response_code(500);
            echo "Erro ao bloquear os dias.";
            exit;
        }
    }
}

$conn->commit();
$stmt->close();
$conn->close();

echo "Dias bloqueados com sucesso.";
?>
