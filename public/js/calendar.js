let monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let dayNames = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'];

let currentDate = new Date();
let currentDay = currentDate.getDate();
let monthNumber = currentDate.getMonth(); // Índice basado en 0 para el mes
let currentYear = currentDate.getFullYear();

let dates = document.getElementById('dates');
let monthElement = document.getElementById('month');
let yearElement = document.getElementById('year');

// Función para escribir los días en el calendario
const writeMonth = (month) => {
    dates.innerHTML = ''; // Limpiar contenido anterior

    // Añadir los nombres de los días
    dayNames.forEach(day => {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar__day calendar__item';
        dayElement.textContent = day;
        dates.appendChild(dayElement);
    });

    // Rellenar días del mes anterior
    for (let i = startDay(); i > 0; i--) {
        const lastDay = getTotalDays(monthNumber === 0 ? 11 : monthNumber - 1); // Manejar enero
        const lastMonthDayElement = document.createElement('div');
        lastMonthDayElement.className = 'calendar__date calendar__item calendar__last-days';
        lastMonthDayElement.textContent = lastDay - (i - 1);
        dates.appendChild(lastMonthDayElement);
    }

    // Rellenar días del mes actual
    for (let i = 1; i <= getTotalDays(month); i++) {
        const isToday = (i === currentDay && monthNumber === new Date().getMonth() && currentYear === new Date().getFullYear());
        const dateElement = document.createElement('div');
        dateElement.className = `calendar__date calendar__item ${isToday ? 'calendar__today' : ''}`;
        dateElement.textContent = i;
        dateElement.dataset.date = `${currentYear}-${monthNumber + 1}-${i}`;

        // Añadir evento para hacer clic en un día
        dateElement.addEventListener('click', function () {
            const selectedDate = this.dataset.date;
            window.livewire.emit('selectDate', selectedDate); // Emitir evento para seleccionar la fecha
        });

        dates.appendChild(dateElement);
    }
};

// Obtener número total de días en un mes
const getTotalDays = (month) => {
    if (month === -1) month = 11; // Diciembre del año anterior
    if ([0, 2, 4, 6, 7, 9, 11].includes(month)) {
        return 31;
    } else if ([3, 5, 8, 10].includes(month)) {
        return 30;
    } else {
        return isLeap() ? 29 : 28; // Febrero
    }
};

// Función para determinar si es año bisiesto
const isLeap = () => {
    return ((currentYear % 100 !== 0) && (currentYear % 4 === 0)) || (currentYear % 400 === 0);
};

// Determinar el día de la semana en el que empieza el mes
const startDay = () => {
    let start = new Date(currentYear, monthNumber, 1);
    return ((start.getDay() - 1) === -1) ? 6 : start.getDay() - 1; // Ajustar para comenzar en lunes
};

// Actualizar el mes y año mostrado
const setNewDate = () => {
    monthElement.textContent = monthNames[monthNumber];
    yearElement.textContent = currentYear.toString();
    writeMonth(monthNumber); // Llenar los días del mes
};

// Eventos para cambiar de mes
document.getElementById('prev-month').addEventListener('click', () => {
    monthNumber = (monthNumber === 0) ? 11 : monthNumber - 1;
    currentYear = (monthNumber === 11) ? currentYear - 1 : currentYear;
    setNewDate();
});

document.getElementById('next-month').addEventListener('click', () => {
    monthNumber = (monthNumber === 11) ? 0 : monthNumber + 1;
    currentYear = (monthNumber === 0) ? currentYear + 1 : currentYear;
    setNewDate();
});

// Botón para regresar al mes y año actual
document.getElementById('today-button').addEventListener('click', () => {
    currentDate = new Date(); // Actualizar a la fecha actual
    monthNumber = currentDate.getMonth();
    currentYear = currentDate.getFullYear();
    currentDay = currentDate.getDate(); // Actualizar el día actual
    setNewDate();
});

// Eventos para abrir y cerrar el modal
window.addEventListener('open-modal', () => {
    // Abrir el modal
    document.getElementById('modal').style.display = 'block';
});

window.addEventListener('close-modal', () => {
    // Cerrar el modal
    document.getElementById('modal').style.display = 'none';
});

// Inicializar el calendario con la fecha actual
setNewDate();
