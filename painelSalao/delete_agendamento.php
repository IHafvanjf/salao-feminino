<?php
include 'config.php';

$id = $_POST['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Agendamento excluído com sucesso.";
} else {
    echo "Erro ao excluir agendamento.";
}
?>
