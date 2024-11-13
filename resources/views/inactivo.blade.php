<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Inactiva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        h1 {
            color: #d9534f;
        }

        p {
            color: #555;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tu cuenta está inactiva</h1>
        <p>Actualmente tu cuenta se encuentra inactiva. Si crees que esto es un error, por favor contacta con el
            administrador para más información.</p>
        <p><a href="{{ route('login') }}">Cerrar sesión</a></p>
    </div>
</body>

</html>
