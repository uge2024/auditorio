<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Solicitud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 10px;
        }

        .section p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detalles de la Solicitud</h1>

        <!-- Información del Usuario -->
        <div class="section">
            <h2>Información del Usuario</h2>
            <p><strong>Nombre:</strong> {{ $solicitud->user->first_name }} {{ $solicitud->user->last_name }}</p>
            <p><strong>Email:</strong> {{ $solicitud->user->email }}</p>
        </div>

        <!-- Detalles del Auditorio -->
        <div class="section">
            <h2>Detalles del Auditorio</h2>
            <p><strong>Nombre:</strong> {{ $solicitud->auditorio->nombre }}</p>
        </div>

        <!-- Fecha y Horarios -->
        <div class="section">
            <h2>Fecha y Horarios</h2>
            <p><strong>Fecha de Uso:</strong> {{ $solicitud->fecha_uso }}</p>
            <p><strong>Hora de Inicio:</strong> {{ $solicitud->hora_inicio }}</p>
            <p><strong>Hora de Finalización:</strong> {{ $solicitud->hora_final }}</p>
            <p><strong>Fecha de Solicitud:</strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Equipos Solicitados -->
        <div class="section">
            <h2>Equipos Solicitados</h2>
            <ul>
                @foreach ($solicitud->equipos as $equipo)
                    <li>{{ $equipo->nombre }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Actividad -->
        <div class="section">
            <h2>Descripción de la Actividad</h2>
            <p>{{ $solicitud->actividad }}</p>
        </div>
    </div>
</body>

</html>
