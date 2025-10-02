<?php
$conn = new mysqli('localhost', 'root', '13579012', 'salao', 3308);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$id = $_POST['id'] ?? 0;
$nome = $_POST['nome'] ?? '';
$horario = $_POST['horario'] ?? '';

$stmt = $conn->prepare("UPDATE agendamentos SET nome = ?, horario = ? WHERE id = ?");
$stmt->bind_param("ssi", $nome, $horario, $id);

if ($stmt->execute()) {
    echo "Agendamento atualizado com sucesso.";
} else {
    echo "Erro ao atualizar agendamento.";
}
?>
