let selectedServices = [];
let selectedDate = "";
let selectedTime = "";

//  Duração de cada serviço (em minutos)
const serviceDurations = {
    "Manicure e Pedicure": 60,
    "Corte de Cabelo": 45,
    "Tratamento Facial": 30,
    "Depilação": 40,
    "Escova": 30,
    "Design de Sobrancelhas": 20,
    "Hidratação Capilar": 50,
    "Maquiagem": 60,
    "Coloração": 90
};

// Variável global para armazenar os dias bloqueados (formato "YYYY-MM-DD")
let blockedDays = [];

function nextStep(step) {
    // Validações por etapa
    if (step === 2) {
        if (selectedServices.length === 0) {
            alert("Selecione pelo menos um serviço para continuar.");
            return;
        }
    }

    if (step === 3) {
        const name = document.getElementById("name").value.trim();
        const phone = document.getElementById("phone").value.trim();

        if (!name || !phone) {
            alert("Por favor, preencha seu nome e telefone.");
            return;
        }
    }

    if (step === 4) {
        if (!selectedDate) {
            alert("Selecione um dia para o agendamento.");
            return;
        }
    }

    if (step === 5) {
        if (!selectedTime) {
            alert("Selecione um horário para o agendamento.");
            return;
        }
    }

    // Se passou pelas validações, avança normalmente
    document.querySelectorAll(".step").forEach(stepDiv => stepDiv.classList.remove("active"));
    document.getElementById(`step${step}`).classList.add("active");
}


function previousStep(step) {
    document.querySelectorAll(".step").forEach(stepDiv => stepDiv.classList.remove("active"));
    document.getElementById(`step${step}`).classList.add("active");
}

function selectService(element) {
    const service = element.querySelector("span").innerText;

    if (selectedServices.includes(service)) {
        selectedServices = selectedServices.filter(s => s !== service);
        element.classList.remove("selected");
    } else {
        selectedServices.push(service);
        element.classList.add("selected");
    }

    fetchOccupiedHours();
}

function getTotalDuration() {
    return selectedServices.reduce((total, service) => total + (serviceDurations[service] || 0), 0);
}

function fetchOccupiedHours() {
    if (!selectedDate) return;

    fetch(`agendamento.php?date=${selectedDate}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                generateSchedule(data.horarios);
            } else {
                console.error("Erro ao buscar horários ocupados:", data.message);
            }
        })
        .catch(error => console.error("Erro na requisição:", error));
}

function generateSchedule(occupiedHours = {}) {

    //  Converte e normaliza horários ocupados para HH:mm
    occupiedHours = Object.values(occupiedHours).map(horario => {
        const [h, m] = horario.split(":");
        return `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`;
    });


    const scheduleGrid = document.getElementById("scheduleGrid");
    scheduleGrid.innerHTML = "";

    let startTime = 8 * 60;
    let endTime = 18 * 60;

    for (let time = startTime; time <= endTime; time += 60) {
        let hours = Math.floor(time / 60);
        let minutes = time % 60;
    
        let formattedTime = `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
    
        let timeButton = document.createElement("button");
        timeButton.classList.add("time-btn");
        timeButton.textContent = formattedTime;
    
        //  Calcula intervalo do agendamento
        let startMinutes = time;
        let totalDuration = getTotalDuration();
        let endMinutes = startMinutes + totalDuration;
    
        //  Verifica se ultrapassa o horário final do dia
        const ultrapassaDia = endMinutes > endTime;
    
        //  Verifica conflito com outros agendamentos
        const conflita = occupiedHours.some(ocupado => {
            const [h, m] = ocupado.split(":");
            const ocupadoMin = parseInt(h) * 60 + parseInt(m);
            return ocupadoMin >= startMinutes && ocupadoMin < endMinutes;
        });
    
        const jaOcupado = occupiedHours.includes(formattedTime);
    
        if (ultrapassaDia || conflita || jaOcupado) {
            timeButton.disabled = true;
            timeButton.classList.remove("selected");
            
            if (jaOcupado) {
                timeButton.classList.add("occupied-red");
                timeButton.setAttribute("title", "Horário já agendado");
            } else {
                timeButton.classList.add("occupied-gray");
                timeButton.setAttribute("title", "Horário indisponível por conflito de duração");
            }
            
            timeButton.classList.add("occupied");
            timeButton.style.color = "white";
            timeButton.style.border = "2px solid #333";
        } else {
            timeButton.onclick = () => {
                document.querySelectorAll(".time-btn").forEach(btn => btn.classList.remove("selected"));
                timeButton.classList.add("selected");
                confirmAppointment(formattedTime);
            };
        }
    
        scheduleGrid.appendChild(timeButton);
    }
}

function confirmAppointment(time) {
    selectedTime = time;
    document.getElementById("confirmationModal").classList.add("show");
}

function finalizeAppointment() {
    const name = document.getElementById("name").value.trim();
    const phone = document.getElementById("phone").value.trim();

    if (!selectedServices.length || !selectedDate || !selectedTime || !name || !phone) {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    const appointmentData = {
        services: selectedServices,
        date: selectedDate,
        time: selectedTime,
        name: name,
        phone: phone,
        duration: getTotalDuration()
    };

    fetch("agendamento.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(appointmentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Agendamento confirmado!");
            window.location.href = "index.php";
        } else {
            alert(`Erro ao agendar: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Erro:", error);
        alert("Erro ao conectar com o servidor.");
    });
}

//  Calendário (Step 3) com bloqueio de dias 

// Função para buscar os dias bloqueados no backend
function fetchBlockedDays() {
    return fetch("../painelSalao/get_blocked_days.php")
        .then(response => response.json())
        .then(data => {
            blockedDays = data; 
        })
        .catch(err => {
            console.error("Erro ao buscar dias bloqueados:", err);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const daysGrid = document.getElementById("daysGrid");
    const currentMonthEl = document.getElementById("currentMonth");
    const prevMonthBtn = document.getElementById("prevMonth");
    const nextMonthBtn = document.getElementById("nextMonth");

    let date = new Date();

    function renderCalendar() {
        daysGrid.innerHTML = "";
        // Calcula o dia da semana do primeiro dia do mês
        const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
        const lastDateOfMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
        const today = new Date();

        currentMonthEl.textContent = date.toLocaleDateString("pt-BR", { month: "long", year: "numeric" });

        // Adiciona células vazias para os dias antes do início do mês
        const emptyCells = (firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1);
        for (let i = 0; i < emptyCells; i++) {
            const emptyDiv = document.createElement("div");
            daysGrid.appendChild(emptyDiv);
        }

        // Cria os dias do mês
        for (let day = 1; day <= lastDateOfMonth; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("day");
            dayDiv.textContent = day;

            // Formata a data atual (dia, mês, ano) no padrão YYYY-MM-DD
            const dia = String(day).padStart(2, "0");
            const mes = String(date.getMonth() + 1).padStart(2, "0");
            const ano = date.getFullYear();
            const currentDateString = `${ano}-${mes}-${dia}`;

            // Se o dia estiver bloqueado, aplica estilo e impede seleção
            if (blockedDays.includes(currentDateString)) {
                dayDiv.classList.add("blocked"); // Certifique-se de definir a classe "blocked" no CSS
                dayDiv.setAttribute("title", "Este dia está indisponível para agendamento");
                dayDiv.addEventListener("click", () => {
                    alert("Este dia está indisponível para agendamento.");
                });
            } else {
                // Se o dia não estiver bloqueado, permite a seleção
                dayDiv.addEventListener("click", () => {
                    document.querySelectorAll(".day").forEach(d => d.classList.remove("selected"));
                    dayDiv.classList.add("selected");
                    selectedDate = currentDateString;
                    fetchOccupiedHours();
                });
            }

            // Destaque para o dia atual
            if (day === today.getDate() &&
                date.getMonth() === today.getMonth() &&
                date.getFullYear() === today.getFullYear()) {
                dayDiv.classList.add("today");
            }

            daysGrid.appendChild(dayDiv);
        }
    }

    prevMonthBtn.addEventListener("click", () => {
        date.setMonth(date.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn.addEventListener("click", () => {
        date.setMonth(date.getMonth() + 1);
        renderCalendar();
    });

    // Primeiro, busca os dias bloqueados e, em seguida, renderiza o calendário
    fetchBlockedDays().then(renderCalendar);
});

