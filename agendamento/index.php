<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php"); // ou a página de login que você usa
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendamento</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <!-- Botão Voltar para o Início -->
    <div class="home-btn-container">
      <a href="../index.php" class="home-btn"><i class="bi bi-house"></i> Início</a>
    </div>

    <!--Escolher Serviço -->
    <div id="step1" class="step active">
      <h2>Escolha o serviço desejado</h2>
      <div class="options">
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico1.jpeg" alt="Corte de Cabelo">
          <span>Manicure e Pedicure</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico2.jpg" alt="Escova">
          <span>Corte de Cabelo</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico3.jpeg" alt="Coloração">
          <span>Tratamento Facial</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico4.jpeg" alt="Coloração">
          <span>Depilação</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico5.jpeg" alt="Coloração">
          <span>Escova</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico6.jpeg" alt="Coloração">
          <span>Design de Sobrancelhas</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico7.jpeg" alt="Coloração">
          <span>Hidratação Capilar</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico8.jpeg" alt="Coloração">
          <span>Maquiagem</span>
          <div class="selected-text">Selecionado</div>
        </div>
        <div class="card service-card" onclick="selectService(this)">
          <img src="../img/servico9.png" alt="Coloração">
          <span>Coloração</span>
          <div class="selected-text">Selecionado</div>
        </div>
      </div>
      <button onclick="nextStep(2)">Próximo</button>
    </div>

    <!--Inserir Nome e Telefone -->
    <div id="step2" class="step">
      <button class="back-btn" onclick="previousStep(1)"></button>
      <h2>Insira seus dados</h2>
      <div class="form-control">
        <input type="text" id="name" placeholder=" " required>
        <label for="name"><span>Nome</span></label>
      </div>
      <div class="form-control">
        <input type="text" id="phone" placeholder=" " required>
        <label for="phone"><span>Telefone</span></label>
      </div>
      <button onclick="nextStep(3)">Confirmar</button>
    </div>

    <!--Escolher Dia -->
    <div id="step3" class="step">
      <button class="back-btn" onclick="previousStep(2)"></button>
      <h2>Selecione o dia</h2>
      <div class="calendar-container">
        <div class="calendar-header">
          <button id="prevMonth">&lt;</button>
          <span id="currentMonth"></span>
          <button id="nextMonth">&gt;</button>
        </div>
        <div class="calendar">
          <div class="days-of-week">
            <span>Seg</span> <span>Ter</span> <span>Qua</span> <span>Qui</span> <span>Sex</span> <span>Sab</span> <span>Dom</span>
          </div>
          <div class="days-grid" id="daysGrid"></div>
        </div>
      </div>
      <button onclick="nextStep(4)">Próximo</button>
    </div>

    <!--Escolher Horário -->
    <div id="step4" class="step">
      <button class="back-btn" onclick="previousStep(3)"></button>
      <h2>Escolha o horário</h2>
      <div class="schedule-container">
        <div class="schedule-grid" id="scheduleGrid"></div>
      </div>

      <!-- Legenda de horários -->
      <div class="legend-container mt-3">
        <span class="legend-box legend-red"></span> Já agendado
        <span class="legend-box legend-gray"></span> Indisponível (conflito)
        <span class="legend-box legend-green"></span> Disponível
      </div>

    </div>
    <!-- Modal de Confirmação -->
    <div id="confirmationModal" class="modal">
      <div class="modal-content">
        <p>Tem certeza que deseja marcar esse horário?</p>
        <button onclick="finalizeAppointment()">Sim</button>
        <button onclick="closeModal()">Não</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
