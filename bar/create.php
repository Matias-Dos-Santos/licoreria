<?php
include 'db.php';

// Crear (Insertar Datos)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $sql = "INSERT INTO usuarios (usuario, contraseña) VALUES ('$usuario', '$contraseña')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado exitosamente<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Actualizar Datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $idusuario = $_POST['idusuario'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $sql = "UPDATE usuarios SET usuario='$usuario', contraseña='$contraseña' WHERE idusuario=$idusuario";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado exitosamente<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Eliminar Datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $idusuario = $_POST['idusuario'];

    $sql = "DELETE FROM usuarios WHERE idusuario=$idusuario";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado exitosamente<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a>Licoreria</a>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="pantalla_principal.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create.php">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="proveedor.php">Proveedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ventas.php">Ventas</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Más
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Informe</a>

                        <a class="dropdown-item" href="#">Ayuda</a>
                            
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Sobre nosotros</a>
                        
                    </div>
                </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>
        </div>
    </nav>







<h3 class="mt-4">Usuarios Registrados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $sql = "SELECT idusuario, usuario, contraseña FROM usuarios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["idusuario"] . "</td>";
                        echo "<td>" . $row["usuario"] . "</td>";
                        echo "<td>" . $row["contraseña"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No hay usuarios registrados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table


    <div class="container">
        <h2 class="mt-4">Crear Usuario</h2>
        <form method="post" action="create.php">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Crear</button>
        </form>

       


        <h2 class="mt-4">Actualizar Usuario</h2>
        <form method="post" action="create.php">
            <div class="form-group">
                <label for="idusuario">ID Usuario:</label>
                <input type="text" class="form-control" id="idusuario" name="idusuario" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" name="update" class="btn btn-warning">Actualizar</button>
        </form>

        <h2 class="mt-4">Eliminar Usuario</h2>
        <form method="post" action="create.php">
            <div class="form-group">
                <label for="idusuario">ID Usuario:</label>
                <input type="text" class="form-control" id="idusuario" name="idusuario" required>
            </div>
            <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
        </form>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


