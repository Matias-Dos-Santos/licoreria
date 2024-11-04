<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: logeo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Bienvenida</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .bienvenida-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="text-center">
    <div class="container d-flex flex-column justify-content-between vh-50">
    <div>
    <div class="bienvenida-container">
        <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h2>
        <p>Sesión iniciada exitosamente.</p>
    </div>
    <div class="mt-auto">
<form action="pantalla_principal.php" method="post">
    <br>
     <button class="btn btn-primary" id="boton-principal">ir a pantalla principal</button>
    </div>
</form>
</body>
</html>
