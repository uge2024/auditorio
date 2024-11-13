<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Solicitudes</title>
    <style>
        /* Estilos del Calendario */
        .calendar {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            width: 100%;
            max-width: 100%;
            padding: 1em;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .calendar:hover {
            transform: scale(1.01);
        }

        .calendar__info {
            display: flex;
            align-items: center;
            padding: 0.5em;
            margin-bottom: 1em;
            justify-content: space-between;
        }

        .calendar__prev,
        .calendar__next {
            cursor: pointer;
            font-size: 1.5em;
            padding: 0.5em;
            background: #ff5100;
            color: white;
            border: none;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
            outline: none;
        }

        .calendar__prev:hover,
        .calendar__next:hover {
            background: #f05c06;
            transform: scale(1.05);
        }

        .calendar__month-year {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 1em;
        }

        .calendar__month,
        .calendar__year {
            font-size: 1.5em;
            color: #333;
        }

        .calendar__days {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1em;
            flex-wrap: wrap;
        }

        .calendar__day {
            flex: 1 0 14%;
            text-align: center;
            font-weight: bold;
            color: #ff4800;
            font-size: 0.9em;
        }

        .calendar__dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.2em;
            margin-bottom: 1em;
        }

        .calendar__date {
            text-align: center;
            padding: 0.5em;
            background: #f9f9f9;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            font-size: 0.9em;
            position: relative;
        }

        .calendar__date:hover {
            background: #e0e0e0;
            transform: scale(1.05);
        }

        .calendar__date.calendar__today {
            background: rgba(105, 105, 104, 0.5);
            border: 2px solid #f0eeed;
            border-radius: 80%;
            position: relative;
        }

        .calendar__date.calendar__today::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: rgba(206, 204, 204, 0.6);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%);
        }

        .indicator.approved {
            background-color: green;
        }

        .indicator.pending {
            background-color: yellow;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(182, 112, 112, 0.2);
            max-width: 700px;
            width: 90%;
            height: 800px;
        }

        .close {
            color: #0a0909;
            float: right;
            font-size: 25px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para la sección de horarios */
        .container {
            display: flex;
        }

        .timings {
            text-align: right;
            padding-right: 5px;
            width: 100px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: white;
            font-size: 0.8em;
            border-right: 1px solid #ffffff;
            height: 500px;
        }

        .timings div {
            position: relative;
            padding: 5px 10px;
        }

        .timings div.current {
            background-color: #b3e0ff;
            font-weight: bold;
            border-radius: 5px;
        }

        #modalDateInfo {
            font-size: 1.2em;
            font-weight: bold;
            color: #0e0d0d;
            text-align: center;
            width: 60%;
        }

        .days {
            position: relative;
            padding-left: 10px;
        }

        .event {
            position: absolute;
            left: 0;
            right: 0;
            background-color: #e6f7ff;
            border-left: 4px solid #000607;
            padding: 6px;
            box-sizing: border-box;
            font-size: 0.6em;
            padding: 4px;
            width: 250px;
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .event .title {
            color: #57b986;
            font-size: 1.2em;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="calendar-header">
        <h1>Calendario de Solicitudes</h1>
        <p>Gestiona y consulta las solicitudes del auditorio aquí</p>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="card card-body border-0 shadow mb-4">
            <div class="row">
                <!-- Filtros de estado y auditorio -->
                <div class="col-md-2">
                    <label for="estado">Filtrar por Estado:</label>
                    <select id="estado" onchange="filtrarSolicitudes()">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="aprobado">Aprobado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="auditorio">Filtrar por Auditorio</label>
                    <select id="auditorio" onchange="filtrarSolicitudes()">
                        <option value="">Todos</option>
                        @foreach ($auditorios as $auditorio)
                            <option value="{{ $auditorio->nombre }}">{{ $auditorio->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="/create-solicitud-user" class="btn btn-sm btn-primary ms-2 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                Crear Nueva Solicitud
            </a>
        </div>

    </div>
    <div class="calendar">
        <div class="calendar__info">
            <button class="calendar__prev" id="prevMonth" aria-label="Mes anterior">&lt;</button>
            <div class="calendar__month-year">
                <div class="calendar__month" id="month" aria-labelledby="month"></div>
                <div class="calendar__year" id="year" aria-labelledby="year"></div>
            </div>
            <button class="calendar__next" id="nextMonth" aria-label="Mes siguiente">&gt;</button>
        </div>

        <div class="calendar__days">
            <div class="calendar__day">Dom</div>
            <div class="calendar__day">Lun</div>
            <div class="calendar__day">Mar</div>
            <div class="calendar__day">Mié</div>
            <div class="calendar__day">Jue</div>
            <div class="calendar__day">Vie</div>
            <div class="calendar__day">Sáb</div>
        </div>

        <div class="calendar__dates" id="calendar"></div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalDateInfo">Fecha seleccionada: </div>
            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
            <div class="container">
                <div class="timings">
                    <div><span>8:00</span> AM</div>
                    <div>8:30</div>
                    <div><span>9:00</span> AM</div>
                    <div>9:30</div>
                    <div><span>10:00</span> AM</div>
                    <div>10:30</div>
                    <div><span>11:00</span> AM</div>
                    <div>11:30</div>
                    <div><span>12:00</span> PM</div>
                    <div>12:30</div>
                    <div><span>13:00</span> PM</div>
                    <div>13:30</div>
                    <div><span>14:00</span> PM</div>
                    <div>14:30</div>
                    <div><span>15:00</span> PM</div>
                    <div>15:30</div>
                    <div><span>16:00</span> PM</div>
                    <div>16:30</div>
                    <div><span>17:00</span> PM</div>
                    <div>17:30</div>
                    <div><span>18:00</span> PM</div>
                    <div>18:30</div>
                </div>
                <div class="days" id="events"></div>
            </div>
        </div>
    </div>

    <script>
        const solicitudes = @json($solicitudes);
        let filteredSolicitudes = solicitudes;
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // Función para aplicar los filtros por estado y auditorio
        function filtrarSolicitudes() {
            const estadoSeleccionado = document.getElementById('estado').value;
            const auditorioSeleccionado = document.getElementById('auditorio').value;

            filteredSolicitudes = Object.keys(solicitudes).reduce((result, fecha) => {
                let solicitudesFiltradas = solicitudes[fecha];

                // Filtrar por estado
                if (estadoSeleccionado) {
                    solicitudesFiltradas = solicitudesFiltradas.filter(solicitud => solicitud.estado ===
                        estadoSeleccionado);
                }

                // Filtrar por auditorio
                if (auditorioSeleccionado) {
                    solicitudesFiltradas = solicitudesFiltradas.filter(solicitud => solicitud.auditorio ===
                        auditorioSeleccionado);
                }

                if (solicitudesFiltradas.length > 0) {
                    result[fecha] = solicitudesFiltradas;
                }

                return result;
            }, {});

            // Actualizar el calendario
            createCalendar();
        }

        // Crear calendario
        function createCalendar() {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';
            const monthElem = document.getElementById('month');
            const yearElem = document.getElementById('year');

            monthElem.textContent = new Intl.DateTimeFormat('es-ES', {
                month: 'long'
            }).format(new Date(currentYear, currentMonth));
            yearElem.textContent = currentYear;

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();

            for (let i = 0; i < firstDay; i++) {
                const emptyElement = document.createElement('div');
                calendar.appendChild(emptyElement);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr =
                    `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                const dayElement = document.createElement('div');
                dayElement.textContent = day;
                dayElement.className = 'calendar__date';

                if (currentDate.getFullYear() === currentYear && currentDate.getMonth() === currentMonth && currentDate
                    .getDate() === day) {
                    dayElement.classList.add('calendar__today');
                }

                if (filteredSolicitudes[dateStr]) {
                    filteredSolicitudes[dateStr].forEach(solicitud => {
                        const indicator = document.createElement('div');
                        indicator.className = 'indicator ' + (solicitud.estado === 'aprobado' ? 'approved' :
                            'pending');
                        dayElement.appendChild(indicator);
                    });
                }

                dayElement.onclick = () => openModal(dateStr);
                calendar.appendChild(dayElement);
            }
        }

        // Función para abrir el modal
        function openModal(dateStr) {
            document.getElementById('modalDateInfo').textContent = `Fecha seleccionada: ${dateStr}`;
            const modal = document.getElementById("myModal");
            modal.style.display = "block";
            layOutRequests(filteredSolicitudes[dateStr] || []);
        }

        document.getElementById('prevMonth').onclick = function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            createCalendar();
        }

        document.getElementById('nextMonth').onclick = function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            createCalendar();
        }

        const modal = document.getElementById("myModal");
        const span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

        const layOutRequests = (requests) => {
            const myNode = document.getElementById("events");
            myNode.innerHTML = '';

            const hours = [
                '08:00', '08:30', '09:00', '09:30',
                '10:00', '10:30', '11:00', '11:30',
                '12:00', '12:30', '13:00', '13:30',
                '14:00', '14:30', '15:00', '15:30',
                '16:00', '16:30', '17:00', '17:30',
                '18:00', '18:30'
            ];

            requests.forEach(request => {
                const startHour = request.hora_inicio.split(':').slice(0, 2).join(':');
                const endHour = request.hora_final.split(':').slice(0, 2).join(':');
                const startIndex = hours.indexOf(startHour);
                const endIndex = hours.indexOf(endHour);

                if (startIndex !== -1 && endIndex !== -1) {
                    const requestDiv = document.createElement('div');
                    requestDiv.className = 'event';
                    requestDiv.innerHTML = `
                        <div class="user">${request.usuario || "Usuario"}</div>
                        <div>Auditorio: ${request.auditorio || "Nombre de auditorio"}</div>
                        <div>Fecha de Solicitud: ${new Date(request.fecha_uso).toLocaleDateString() || "No especificada"}</div>
                        <div>Hora de Inicio: <strong>${request.hora_inicio || "Hora de inicio"}</strong></div>
                        <div>Hora de Fin: ${request.hora_final || "Hora de fin"}</div>
                    `;

                    requestDiv.style.backgroundColor = request.estado === 'pendiente' ?
                        'rgba(255, 255, 0, 0.5)' : 'rgba(144, 238, 144, 0.5)';

                    const eventDuration = endIndex - startIndex;
                    requestDiv.style.top = `${startIndex * 30}px`;
                    requestDiv.style.height = `${eventDuration * 30}px`;
                    myNode.appendChild(requestDiv);
                }
            });
        }

        window.onload = function() {
            createCalendar();
        }
    </script>
</body>

</html>
