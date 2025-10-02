<?php
// get_blocked_days.php

require 'config.php';

header('Content-Type: application/json');

$sql = "SELECT data_bloqueada FROM blocked_days";
$result = $conn->query($sql);

$blockedDays = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $blockedDays[] = $row['data_bloqueada'];
    }
    echo json_encode($blockedDays);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar os dias bloqueados']);
}

$conn->close();
?>
