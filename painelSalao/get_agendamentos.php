<?php

include 'config.php';
$data = $_GET['data'] ?? '';
$stmt = $conn->prepare("SELECT id, nome, horario, telefone, servicos, duracao FROM agendamentos WHERE data = ?");
$stmt->bind_param("s", $data);
$stmt->execute();
$result = $stmt->get_result();

$agendamentos = [];
while ($row = $result->fetch_assoc()) {
    $agendamentos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($agendamentos);
?>
