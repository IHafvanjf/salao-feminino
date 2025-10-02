// ================================
// Painel de Agendamentos e Administração
// ================================

// Variáveis do calendário de agendamentos
let today = new Date().getDate();
let todayMonth = new Date().getMonth();
let todayYear = new Date().getFullYear();
let currentMonth = todayMonth;
let currentYear = todayYear;
let selectedDay = null;
let modalMonth = new Date().getMonth();
let modalYear = new Date().getFullYear();
let modalMonthDesbloqueio = new Date().getMonth();
let modalYearDesbloqueio = new Date().getFullYear();


const monthNames = [
  "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
  "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
];

// Atualiza o calendário principal
function updateCalendars() {
  document.querySelector(".monthName").textContent = `${monthNames[currentMonth]} ${currentYear}`;
  const daysList = document.querySelector(".daysList");
  daysList.innerHTML = "";
  const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

  for (let day = 1; day <= daysInMonth; day++) {
    const date = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const btn = document.createElement("button");
    btn.className = "px-4 py-2 border border-gray-300 rounded-lg transition";
    btn.textContent = day;

    if (selectedDay === day) {
      btn.classList.add("bg-pink-500", "text-white");
    } else if (day === today && currentMonth === todayMonth && currentYear === todayYear) {
      btn.classList.add("bg-pink-200", "font-bold");
    } else {
      btn.classList.add("bg-white", "text-gray-900", "hover:bg-pink-500", "hover:text-white");
    }

    btn.onclick = () => {
      selectedDay = day;
      updateCalendars();
      buscarAgendamentos(date);
    };

    daysList.appendChild(btn);
  }
}

function changeMonth(step) {
  currentMonth += step;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  } else if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  selectedDay = null;
  updateCalendars();
}

document.addEventListener("DOMContentLoaded", () => {
  updateCalendars();
});

// Busca agendamentos do dia selecionado
function buscarAgendamentos(data) {
  fetch(`get_agendamentos.php?data=${data}`)
    .then(res => res.json())
    .then(agendamentos => {
      const tbody = document.getElementById("agendamentosBody");
      tbody.innerHTML = "";

      if (agendamentos.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="7" class="text-center text-gray-500 py-4">Nenhum agendamento encontrado.</td>`;
        tbody.appendChild(row);
        return;
      }

      agendamentos.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${item.nome}</td>
          <td>${item.horario}</td>
          <td>${item.telefone}</td>
          <td>${item.servicos?.replace(/["[\]]/g, '') || 'Nenhum'}</td>
          <td>${item.duracao || "N/A"} min</td>
          <td>
            <button class="text-red-600 underline" onclick="deletarAgendamento(${item.id})">Excluir</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(error => {
      console.error("Erro ao buscar agendamentos:", error);
    });
}

function deletarAgendamento(id) {
  if (!confirm("Tem certeza que deseja excluir este agendamento?")) return;

  fetch("delete_agendamento.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${id}`
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      updateCalendars();
      if (selectedDay) {
        const date = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
        buscarAgendamentos(date);
      }
    })
    .catch(error => {
      console.error("Erro ao excluir agendamento:", error);
    });
}

function editarAgendamento(id) {
  const novoNome = prompt("Novo nome:");
  const novoHorario = prompt("Novo horário (ex: 14:30):");

  if (!novoNome || !novoHorario) return;

  fetch("update_agendamento.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${id}&nome=${encodeURIComponent(novoNome)}&horario=${encodeURIComponent(novoHorario)}`
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      updateCalendars();
      if (selectedDay) {
        const date = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
        buscarAgendamentos(date);
      }
    })
    .catch(error => {
      console.error("Erro ao editar agendamento:", error);
    });
}

// ============================================
// Área Administrativa - Bloquear/Desbloquear Dias
// ============================================

// Variáveis para controle de bloqueios
let blockedDates = [];          // Dias já bloqueados (ex: "2025-04-15")
let selectedBlockDates = [];    // Dias selecionados para bloqueio
let selectedUnblockDates = [];  // Dias selecionados para desbloqueio

// Funções para abrir/fechar os modais
function abrirModalBloquear() {
  document.getElementById("modal-bloquear").classList.remove("hidden");
  carregarBloqueios();
}

function fecharModalBloquear() {
  document.getElementById("modal-bloquear").classList.add("hidden");
  selectedBlockDates = [];
}

function abrirModalDesbloquear() {
  document.getElementById("modal-desbloquear").classList.remove("hidden");
  carregarBloqueios();
}

function fecharModalDesbloquear() {
  document.getElementById("modal-desbloquear").classList.add("hidden");
  selectedUnblockDates = [];
}

// Carrega os dias bloqueados do backend
function carregarBloqueios() {
  fetch("get_blocked_days.php")
    .then(res => res.json())
    .then(data => {
      const hoje = new Date();
      blockedDates = data.filter(date => {
        const d = new Date(date + "T00:00:00");
        return d >= new Date(hoje.toDateString()); // Mantém apenas dias futuros
      });

      gerarCalendarioBloquear();
      gerarCalendarioDesbloquear();
    })
    .catch(error => {
      console.error("Erro ao carregar dias bloqueados:", error);
    });
}


// Gera o calendário para bloqueio de dias (mês atual)
function gerarCalendarioBloquear() {
  const calendarDiv = document.querySelector('.calendar-block');
  const mesSpan = document.getElementById("mesModalBloquear");
  calendarDiv.innerHTML = "";
  mesSpan.textContent = `${monthNames[modalMonth]} ${modalYear}`;

  const daysInMonth = new Date(modalYear, modalMonth + 1, 0).getDate();

  for (let day = 1; day <= daysInMonth; day++) {
    const date = `${modalYear}-${String(modalMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const btn = document.createElement("button");
    btn.textContent = day;
    btn.className = "px-2 py-1 border rounded transition";

    if (blockedDates.includes(date)) {
      btn.classList.add("bg-gray-400", "cursor-not-allowed");
      btn.disabled = true;
    } else {
      btn.classList.add("bg-white", "hover:bg-green-300");
      btn.addEventListener("click", () => {
        if (selectedBlockDates.includes(date)) {
          selectedBlockDates = selectedBlockDates.filter(d => d !== date);
          btn.classList.remove("bg-green-500", "text-white");
        } else {
          selectedBlockDates.push(date);
          btn.classList.add("bg-green-500", "text-white");
        }
      });
    }

    calendarDiv.appendChild(btn);
  }
}

function alterarMesModal(passo, tipo) {
  if (tipo === 'bloquear') {
    modalMonth += passo;
    if (modalMonth < 0) {
      modalMonth = 11;
      modalYear--;
    } else if (modalMonth > 11) {
      modalMonth = 0;
      modalYear++;
    }
    gerarCalendarioBloquear();
  } else {
    modalMonthDesbloqueio += passo;
    if (modalMonthDesbloqueio < 0) {
      modalMonthDesbloqueio = 11;
      modalYearDesbloqueio--;
    } else if (modalMonthDesbloqueio > 11) {
      modalMonthDesbloqueio = 0;
      modalYearDesbloqueio++;
    }
    gerarCalendarioDesbloquear();
  }
}


// Gera o calendário para desbloqueio (apenas os dias já bloqueados)
function gerarCalendarioDesbloquear() {
  const calendarDiv = document.querySelector('.calendar-unblock');
  const mesSpan = document.getElementById("mesModalDesbloquear");
  calendarDiv.innerHTML = "";
  mesSpan.textContent = `${monthNames[modalMonthDesbloqueio]} ${modalYearDesbloqueio}`;

  const diasFiltrados = blockedDates.filter(date => {
    const d = new Date(date);
    return d.getMonth() === modalMonthDesbloqueio && d.getFullYear() === modalYearDesbloqueio;
  });

  if (diasFiltrados.length === 0) {
    calendarDiv.textContent = "Nenhum dia bloqueado neste mês.";
    return;
  }

  diasFiltrados.forEach(date => {
    const btn = document.createElement("button");
    const day = new Date(date).getDate();
    btn.textContent = day;
    btn.className = "px-2 py-1 border rounded bg-red-500 text-white transition";

    btn.addEventListener("click", () => {
      if (selectedUnblockDates.includes(date)) {
        selectedUnblockDates = selectedUnblockDates.filter(d => d !== date);
        btn.classList.remove("bg-yellow-500", "text-black");
        btn.classList.add("bg-red-500", "text-white");
      } else {
        selectedUnblockDates.push(date);
        btn.classList.remove("bg-red-500", "text-white");
        btn.classList.add("bg-yellow-500", "text-black");
      }
    });

    calendarDiv.appendChild(btn);
  });
}


// Confirma o bloqueio dos dias selecionados
function confirmarBloqueio() {
  if (selectedBlockDates.length === 0) {
    alert("Nenhum dia selecionado para bloqueio.");
    return;
  }
  
  const data = new URLSearchParams();
  selectedBlockDates.forEach(date => data.append("dias[]", date));
  
  fetch("block_days.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: data.toString()
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      fecharModalBloquear();
      carregarBloqueios(); // Atualiza os dias bloqueados
    })
    .catch(error => {
      console.error("Erro ao bloquear dias:", error);
    });
}

// Confirma o desbloqueio dos dias selecionados
function confirmarDesbloqueio() {
  if (selectedUnblockDates.length === 0) {
    alert("Nenhum dia selecionado para desbloqueio.");
    return;
  }

  const data = new URLSearchParams();
  selectedUnblockDates.forEach(date => data.append("dias[]", date));

  fetch("unblock_days.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: data.toString()
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      selectedUnblockDates = []; // limpa seleção
      carregarBloqueios();       // recarrega bloqueios atualizados
      fecharModalDesbloqueio();  // fecha modal automaticamente
    })
    .catch(error => {
      console.error("Erro ao desbloquear dias:", error);
    });
}

