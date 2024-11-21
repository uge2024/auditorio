<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Solicitud</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007BFF;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f7f9fc;
        }

        .section h2 {
            font-size: 18px;
            color: #555;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .section p,
        .section ul {
            margin: 5px 0;
            font-size: 14px;
        }

        .section ul {
            padding-left: 20px;
        }

        .section ul li {
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
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
                @forelse ($solicitud->equipos as $equipo)
                    <li>{{ $equipo->nombre }}</li>
                @empty
                    <p>No se solicitaron equipos.</p>
                @endforelse
            </ul>
        </div>

        <!-- Actividad -->
        <div class="section">
            <h2>Descripción de la Actividad</h2>
            <p>{{ $solicitud->actividad }}</p>
        </div>

        <!-- Pie de Página -->
        <div class="footer">
            Generado automáticamente por el Sistema de Auditorios | &copy; {{ now()->year }}
        </div>
    </div>
</body>

</html>
