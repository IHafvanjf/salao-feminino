<?php
header("Content-Type: application/json");

include('../login/config.php');

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Erro na conexão com o banco: " . $conn->connect_error]);
    exit();
}

// 🔹 BUSCAR HORÁRIOS OCUPADOS 🔹
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["date"])) {
    $dataSelecionada = date("Y-m-d", strtotime(str_replace("/", "-", $_GET["date"])));

    $sql = "SELECT horario, duracao FROM agendamentos WHERE data = '$dataSelecionada'";
    $result = $conn->query($sql);

    if (!$result) {
        echo json_encode(["success" => false, "message" => "Erro na consulta: " . $conn->error]);
        exit();
    }

    $horariosOcupados = [];

    while ($row = $result->fetch_assoc()) {
        $horarioInicial = strtotime($row["horario"]);
        $horarioFinal = $horarioInicial + ($row["duracao"] * 60); // Adiciona a duração

        for ($h = $horarioInicial; $h < $horarioFinal; $h += 3600) {
            $horariosOcupados[] = date("H:i", $h); // Adiciona todos os horários ocupados
        }
    }

    echo json_encode(["success" => true, "horarios" => array_unique($horariosOcupados)]);
    exit();
}

// 🔹 SALVAR NOVO AGENDAMENTO 🔹
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["services"], $data["date"], $data["time"], $data["name"], $data["phone"], $data["duration"])) {
    $nome = $conn->real_escape_string($data["name"]);
    $telefone = $conn->real_escape_string($data["phone"]);
    $servicos = $conn->real_escape_string(implode(", ", $data["services"]));
    $dataAgendamento = date("Y-m-d", strtotime(str_replace("/", "-", $data["date"])));
    $horario = $conn->real_escape_string($data["time"]);
    $duracao = intval($data["duration"]);

    $sql = "INSERT INTO agendamentos (nome, telefone, servicos, data, horario, duracao) 
            VALUES ('$nome', '$telefone', '$servicos', '$dataAgendamento', '$horario', '$duracao')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Agendamento realizado com sucesso"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao salvar: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dados incompletos"]);
}

$conn->close();
?>
