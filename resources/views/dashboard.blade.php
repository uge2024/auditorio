<div class="dashboard">
    <style>
        .auditorio-list {
            display: flex;
            flex-wrap: wrap;
        }

        .auditorio-card {
            flex: 1 1 calc(33.333% - 10px);
            margin: 5px;
            background: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
        }

        .auditorio-card:hover {
            transform: scale(1.05);
        }

        .auditorio-imagen {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .auditorio-info {
            padding: 10px;
            text-align: center;
        }

        .btn-auditorio,
        .btn-reserve {
            background-color: #2e3842;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 5px;
        }

        .btn-auditorio:hover,
        .btn-reserve:hover {
            background-color: #b32a00;
        }

        .btn-reserve {
            background-color: #28a745;
        }

        .btn-reserve:hover {
            background-color: #218838;
        }

        .equipos-miniaturas {
            padding: 10px;
        }

        .miniaturas {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .miniatura {
            text-align: center;
            margin: 5px;
        }

        .miniatura img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        /* Estilos del calendario */
        .calendario {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            overflow: hidden;
        }

        .calendario-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .dia-header {
            font-weight: bold;
            text-align: center;
            background-color: #f0f0f0;
            padding: 5px;
            border-radius: 5px;
        }

        .dia {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 5px;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            position: relative;
            cursor: pointer;
        }

        .dia:hover {
            background-color: #e2e6ea;
            transform: scale(1.1);
        }

        /* Indicadores de solicitudes aprobadas y pendientes */
        .indicator {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .approved {
            background-color: green;
        }

        .pending {
            background-color: yellow;
        }

        .ver-calendario {
            display: inline-block;
            margin-top: 10px;
            color: #ccd6e0;
            font-weight: bold;
        }

        .ver-calendario:hover {
            text-decoration: underline;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .calendario-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .calendario-navigation button {
            background-color: #ac7834;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .calendario-navigation select {
            padding: 5px;
        }

        .calendario-navigation button:hover {
            background-color: #b30000;
        }

        /* Ajustes para responsividad */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-12 {
            flex: 1 1 100%;
        }

        .col-md-8,
        .col-xl-4 {
            flex: 1 1 calc(50% - 20px);
            margin: 10px;
        }

        @media (max-width: 768px) {

            .col-md-8,
            .col-xl-4 {
                flex: 1 1 100%;
            }
        }

        /* Ajustes para las tarjetas */
        .auditorio-card {
            overflow: hidden;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Popup de auditorios */
        #auditorio-popup {
            position: absolute;
            background-color: white;
            border: 1px solid #dee2e6;
            padding: 10px;
            display: none;
            z-index: 1000;
        }
    </style>

    <!-- Popup para mostrar los auditorios solicitados -->
    <div id="auditorio-popup">
        <p id="popup-content"></p>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Calendario de Eventos</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="card card-body border-0 shadow mb-4">
                <div class="calendario-navigation">
                    <button onclick="changeMonth(-1)">Anterior</button>
                    <div>
                        <select id="month-select" onchange="updateCalendar()">
                            <option value="0">Enero</option>
                            <option value="1">Febrero</option>
                            <option value="2">Marzo</option>
                            <option value="3">Abril</option>
                            <option value="4">Mayo</option>
                            <option value="5">Junio</option>
                            <option value="6">Julio</option>
                            <option value="7">Agosto</option>
                            <option value="8">Septiembre</option>
                            <option value="9">Octubre</option>
                            <option value="10">Noviembre</option>
                            <option value="11">Diciembre</option>
                        </select>
                        <select id="year-select" onchange="updateCalendar()"></select>
                    </div>
                    <button onclick="changeMonth(1)">Siguiente</button>
                </div>
                <div class="calendario">
                    <div id="calendar-grid" class="calendario-grid">
                        <div class="dia-header">Lun</div>
                        <div class="dia-header">Mar</div>
                        <div class="dia-header">Mie</div>
                        <div class="dia-header">Jue</div>
                        <div class="dia-header">Vie</div>
                        <div class="dia-header">Sab</div>
                        <div class="dia-header">Dom</div>
                    </div>
                    <a href="{{ route('calendar-user') }}" class="ver-calendario">Ver Calendario Principal</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card card-body border-0 shadow mb-4">
                <div class="header">
                    <h2>Auditorios</h2>
                </div>
                <div class="auditorio-list">
                    @foreach ($auditorios as $auditorio)
                        <div class="auditorio-card">
                            <img src="{{ asset('storage/' . $auditorio->imagen) }}" alt="{{ $auditorio->nombre }}"
                                class="auditorio-imagen">
                            <div class="auditorio-info">
                                <h3>{{ $auditorio->nombre }}</h3>
                                <p>Capacidad: {{ $auditorio->capacidad }} personas</p>
                            </div>
                            @if ($auditorio->equipos->isNotEmpty())
                                <div class="equipos-miniaturas">
                                    <h4>Equipos:</h4>
                                    <div class="miniaturas">
                                        @foreach ($auditorio->equipos as $equipo)
                                            <div class="miniatura">
                                                <img src="{{ asset('storage/' . $equipo->imagen) }}"
                                                    alt="{{ $equipo->nombre }}">
                                                <span>{{ $equipo->nombre }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        const solicitudes = @json($solicitudes); // Recibe las solicitudes desde el backend

        const monthSelect = document.getElementById('month-select');
        const yearSelect = document.getElementById('year-select');
        const calendarGrid = document.getElementById('calendar-grid');
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth();

        monthSelect.value = currentMonth;

        for (let i = currentYear - 5; i <= currentYear + 5; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.text = i;
            if (i === currentYear) option.selected = true;
            yearSelect.add(option);
        }

        function getDaysInMonth(month, year) {
            return new Date(year, month + 1, 0).getDate();
        }

        function getFirstDayOfMonth(month, year) {
            return new Date(year, month, 1).getDay();
        }

        function clearCalendar() {
            const calendarDays = document.querySelectorAll('.calendar-day, .empty');
            calendarDays.forEach(day => day.remove());
        }

        function updateCalendar() {
            clearCalendar();

            const selectedMonth = parseInt(monthSelect.value);
            const selectedYear = parseInt(yearSelect.value);
            const daysInMonth = getDaysInMonth(selectedMonth, selectedYear);
            const firstDay = getFirstDayOfMonth(selectedMonth, selectedYear);

            let emptySlots = firstDay === 0 ? 6 : firstDay - 1;
            for (let i = 0; i < emptySlots; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.classList.add('empty');
                calendarGrid.appendChild(emptyDiv);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('dia', 'calendar-day');
                dayDiv.innerText = day;

                const dateStr =
                    `${selectedYear}-${(selectedMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

                // Filtrar solicitudes por la fecha actual
                const solicitudesDelDia = solicitudes.filter(solicitud => solicitud.fecha_uso === dateStr);

                solicitudesDelDia.forEach(solicitud => {
                    const indicator = document.createElement('div');
                    indicator.className = 'indicator ' + (solicitud.estado === 'aprobado' ? 'approved' : 'pending');
                    dayDiv.appendChild(indicator);
                });

                // Evento mouseover para mostrar auditorios
                // Evento mouseover para mostrar auditorios
                dayDiv.addEventListener('mouseover', (e) => {
                    const popup = document.getElementById('auditorio-popup');
                    const popupContent = document.getElementById('popup-content');
                    let content = 'Auditorios solicitados:<br>';

                    solicitudesDelDia.forEach(solicitud => {
                        // Verificar si la solicitud tiene auditorio asociado
                        content +=
                            ` ${solicitud.auditorio ? solicitud.auditorio.nombre : 'Nombre no disponible'}<br>`;
                    });

                    if (solicitudesDelDia.length === 0) {
                        content = 'No hay solicitudes.';
                    }

                    popupContent.innerHTML = content;
                    popup.style.display = 'block';
                    popup.style.left = e.pageX + 'px';
                    popup.style.top = e.pageY + 'px';
                });


                // Evento mouseout para esconder el popup
                dayDiv.addEventListener('mouseout', () => {
                    const popup = document.getElementById('auditorio-popup');
                    popup.style.display = 'none';
                });

                calendarGrid.appendChild(dayDiv);
            }
        }

        function changeMonth(change) {
            let selectedMonth = parseInt(monthSelect.value) + change;
            let selectedYear = parseInt(yearSelect.value);

            if (selectedMonth < 0) {
                selectedMonth = 11;
                selectedYear -= 1;
            } else if (selectedMonth > 11) {
                selectedMonth = 0;
                selectedYear += 1;
            }

            monthSelect.value = selectedMonth;
            yearSelect.value = selectedYear;
            updateCalendar();
        }

        window.onload = updateCalendar;
    </script>
</div>
