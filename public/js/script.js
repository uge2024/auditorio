const calendar = document.getElementById("calendar");
const addRequestBtn = document.getElementById("addRequestBtn");
const requestModal = document.getElementById("requestModal");
const closeModal = document.querySelector(".close");
const saveRequestBtn = document.getElementById("saveRequestBtn");
const requestTitleInput = document.getElementById("requestTitle");
const requestDateInput = document.getElementById("requestDate");
const requestTimeInput = document.getElementById("requestTime");
const recurrenceInput = document.getElementById("recurrence");
const requestColorInput = document.getElementById("requestColor");
const searchInput = document.getElementById("searchInput");
const toggleThemeBtn = document.getElementById("toggleThemeBtn");

let requests = [];
let currentMonth = new Date().getMonth();
let currentYear = new Date().getFullYear();
let darkMode = false;

// Cargar solicitudes desde localStorage
function loadRequests() {
    const storedRequests = JSON.parse(localStorage.getItem('requests')) || [];
    requests = storedRequests;
    displayRequests();
}

// Guardar solicitudes en localStorage
function saveRequests() {
    localStorage.setItem('requests', JSON.stringify(requests));
}

// Cerrar el modal
closeModal.onclick = () => {
    requestModal.style.display = "none";
};

// Mostrar el modal para agregar una solicitud
addRequestBtn.onclick = () => {
    requestModal.style.display = "block";
};

// Guardar la solicitud
saveRequestBtn.onclick = () => {
    const title = requestTitleInput.value;
    const date = requestDateInput.value;
    const time = requestTimeInput.value;
    const recurrence = recurrenceInput.value;
    const color = requestColorInput.value;

    if (title && date && time) {
        const request = { title, date, time, recurrence, color };
        requests.push(request);

        // Manejar solicitudes recurrentes
        if (recurrence !== "none") {
            handleRecurrence(request);
        }

        saveRequests();
        displayRequests();
        requestModal.style.display = "none";
    } else {
        alert("Por favor completa todos los campos.");
    }
};

// Manejar solicitudes recurrentes
function handleRecurrence(request) {
    const startDate = new Date(request.date);
    let nextDate;

    if (request.recurrence === "daily") {
        for (let i = 1; i < 30; i++) { // Generar hasta 30 días
            nextDate = new Date(startDate);
            nextDate.setDate(startDate.getDate() + i);
            requests.push({ ...request, date: nextDate.toISOString().split('T')[0] });
        }
    } else if (request.recurrence === "weekly") {
        for (let i = 1; i < 30; i += 7) { // Generar cada semana
            nextDate = new Date(startDate);
            nextDate.setDate(startDate.getDate() + i);
            requests.push({ ...request, date: nextDate.toISOString().split('T')[0] });
        }
    } else if (request.recurrence === "monthly") {
        for (let i = 1; i < 12; i++) { // Generar cada mes
            nextDate = new Date(startDate);
            nextDate.setMonth(startDate.getMonth() + i);
            requests.push({ ...request, date: nextDate.toISOString().split('T')[0] });
        }
    }
}

// Mostrar las solicitudes en el calendario
function displayRequests() {
    calendar.innerHTML = ""; // Limpiar el calendario
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

    // Filtrar solicitudes por búsqueda
    const searchTerm = searchInput.value.toLowerCase();
    const filteredRequests = requests.filter(request =>
        request.title.toLowerCase().includes(searchTerm) ||
        request.date.includes(searchTerm)
    );

    for (let i = 1; i <= daysInMonth; i++) {
        const dayDiv = document.createElement("div");
        dayDiv.className = "day";
        dayDiv.innerText = i;

        // Filtrar solicitudes por fecha
        const dayRequests = filteredRequests.filter(request => {
            const requestDate = new Date(request.date);
            return requestDate.getDate() === i && requestDate.getMonth() === currentMonth && requestDate.getFullYear() === currentYear;
        });

        // Crear tooltip solo si hay solicitudes
        if (dayRequests.length > 0) {
            const tooltip = document.createElement("div");
            tooltip.className = "tooltip";

            // Ordenar solicitudes por hora
            dayRequests.sort((a, b) => new Date(`1970-01-01T${a.time}:00`) - new Date(`1970-01-01T${b.time}:00`));

            // Agregar solicitudes al tooltip
            dayRequests.forEach(request => {
                tooltip.innerHTML += `${request.time}: ${request.title}<br>`;
            });

            // Mostrar tooltip al pasar el mouse
            dayDiv.addEventListener('mouseenter', () => {
                tooltip.style.display = 'block';
            });

            // Ocultar tooltip al salir
            dayDiv.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });

            dayDiv.appendChild(tooltip);
        }

        // Crear puntos para solicitudes
        dayRequests.forEach(request => {
            const dot = document.createElement("div");
            dot.className = "event-dot";
            dot.style.backgroundColor = request.color; // Cambiar el color según la selección
            dayDiv.appendChild(dot);
        });

        calendar.appendChild(dayDiv);
    }
}

// Navegar al mes anterior
document.getElementById("prevMonthBtn").onclick = () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    displayRequests();
};

// Navegar al mes siguiente
document.getElementById("nextMonthBtn").onclick = () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    displayRequests();
};

// Cargar solicitudes al iniciar
window.onload = loadRequests;

// Para cerrar el modal al hacer clic fuera de él
window.onclick = (event) => {
    if (event.target === requestModal) {
        requestModal.style.display = "none";
    }
};

// Funcionalidad del modo oscuro
toggleThemeBtn.onclick = () => {
    darkMode = !darkMode;
    document.body.classList.toggle("dark-mode", darkMode);
};

// Filtrado de búsqueda
searchInput.addEventListener("input", displayRequests);
