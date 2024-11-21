<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            color: #333;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            font-size: 50px;
            color: #000;
            z-index: -1;
        }

        main {
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        .page-number {
            position: absolute;
            bottom: 10px;
            right: 20px;
        }

        .summary {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }

        .comments {
            margin-top: 20px;
            font-style: italic;
        }

        @media (forced-colors: active) {
            body {
                background-color: Window;
                /* Color de fondo del sistema */
                color: WindowText;
                /* Color de texto del sistema */
            }

            table {
                border-color: WindowText;
            }

            th {
                background-color: Highlight;
                /* Color de fondo resaltado */
                color: HighlightText;
                /* Color de texto resaltado */
            }
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ asset('images/profile-picture-1.jpg') }}" alt="Logo" style="width: 100px;">
        <div class="title">Gobierno Autónomo Departamental de Cochabamba</div>
        <h2>Reporte de Solicitudes</h2>
        <p>Fecha Generado: {{ now()->format('d/m/Y') }}</p>

        <div class="watermark">DRAFT</div>
    </header>

    <main>
        <h1>Detalles de Solicitudes</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Unidad</th>
                    <th>Dirección</th>
                    <th>Auditorio</th>
                    <th>Nombre Equipo</th>
                    <th>Código Equipo</th>
                    <th>Fecha de Uso</th>
                    <th>Hora Inicio</th>
                    <th>Hora Final</th>
                    <th>Actividad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportes as $solicitud)
                    <tr
                        style="background-color: {{ $solicitud->estado == 'aprobado' ? '#e8f5e9' : ($solicitud->estado == 'rechazado' ? '#ffebee' : '#fff') }};">
                        <td>{{ $solicitud->id_solicitud }}</td>
                        <td>{{ $solicitud->user->first_name ?? 'N/A' }}</td>
                        <td>{{ $solicitud->user->unidad ?? 'N/A' }}</td>
                        <td>{{ $solicitud->user->address ?? 'N/A' }}</td>
                        <td>{{ $solicitud->auditorio->nombre ?? 'N/A' }}</td>
                        <td>{{ $solicitud->equipo->nombre ?? 'N/A' }}</td>
                        <td>{{ $solicitud->equipo->codigo ?? 'N/A' }}</td>
                        <td>{{ $solicitud->fecha_uso }}</td>
                        <td>{{ $solicitud->hora_inicio }}</td>
                        <td>{{ $solicitud->hora_final }}</td>
                        <td>{{ $solicitud->actividad }}</td>
                        <td>{{ $solicitud->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="summary">
            Total Solicitudes: {{ $reportes->count() }}
        </div>
        <div class="comments">
            Comentarios: ____________________________________________________________
        </div>
    </main>

    <footer>
        <div class="page-number">Página: {PAGE_NUM} de {PAGE_COUNT}</div>
        <p>&copy; {{ now()->format('Y') }} Gobierno Autónomo Departamental de Cochabamba. Todos los derechos
            reservados.</p>
        <p>Contacto: info@gobierno.gob.bo | Tel: (123) 456-7890</p>
    </footer>

</body>

</html>
