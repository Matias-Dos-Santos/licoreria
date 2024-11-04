<?php
include 'db.php';

// Crear (Insertar Datos)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $nomdist = $_POST['nombredist'] ?? null;
    $tel = $_POST['telefono'] ?? null;

    if ($nomdist && $tel) { // Validar que no estén vacíos
        // Usar sentencias preparadas
        $stmt = $conn->prepare("INSERT INTO proveedor (nombredist, telefono) VALUES (?, ?)");
        $stmt->bind_param("ss", $nomdist, $tel); // Ajustar para no usar idProveedor

        if ($stmt->execute()) {
            echo "Proveedor registrado exitosamente<br>";
        } else {
            echo "Error al registrar el proveedor: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Por favor completa todos los campos requeridos.<br>";
    }
}

// Actualizar Datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $nomdist = $_POST['nombredist'] ?? null;
    $tel = $_POST['telefono'] ?? null;
    $idProveedor = $_POST['idProveedor'] ?? null;

    if ($nomdist && $tel && $idProveedor) { // Validar que no estén vacíos
        // Usar sentencias preparadas
        $stmt = $conn->prepare("UPDATE proveedor SET nombredist=?, telefono=? WHERE idProveedor=?");
        $stmt->bind_param("ssi", $nomdist, $tel, $idProveedor);

        if ($stmt->execute()) {
            echo "Proveedor actualizado exitosamente<br>";
        } else {
            echo "Error al actualizar el proveedor: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Por favor completa todos los campos requeridos.<br>";
    }
}

// Eliminar Datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $idProveedor = $_POST['idProveedor'] ?? null;

    if ($idProveedor) { // Validar que no esté vacío
        // Usar sentencias preparadas
        $stmt = $conn->prepare("DELETE FROM proveedor WHERE idProveedor=?");
        $stmt->bind_param("i", $idProveedor); 

        if ($stmt->execute()) {
            echo "Proveedor eliminado exitosamente<br>";
        } else {
            echo "Error al eliminar el proveedor: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Por favor proporciona el ID del proveedor.<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Licoreria</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="pantalla_principal.php">Inicio</a>
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Más</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Informe</a>
                    <a class="dropdown-item" href="#">Ayuda</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Sobre nosotros</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
</nav>

<h3 class="mt-4">Proveedores Registrados</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Proveedor</th>
            <th>Nombre distribuidor</th>
            <th>Teléfono</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'db.php';
        $sql = "SELECT idProveedor, nombredist, telefono FROM proveedor";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["idProveedor"] . "</td>";
                echo "<td>" . $row["nombredist"] . "</td>";
                echo "<td>" . $row["telefono"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay Proveedores registrados</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>

<div class="container">
    <h2 class="mt-4">Añadir Proveedor</h2>
    <form method="post" action="proveedor.php">
        <div class="form-group">
            <label for="nombredist">Nombre distribuidor:</label>
            <input type="text" class="form-control" id="nombredist" name="nombredist" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono distribuidor:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <button type="submit" name="create" class="btn btn-primary">Añadir</button>
    </form>

    <h2 class="mt-4">Actualizar Proveedor</h2>
    <form method="post" action="proveedor.php">
        <div class="form-group">
            <label for="idProveedor">ID proveedor:</label>
            <input type="text" class="form-control" id="idProveedor" name="idProveedor" required>
        </div>
        <div class="form-group">
            <label for="nombredist">Nombre distribuidor:</label>
            <input type="text" class="form-control" id="nombredist" name="nombredist" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <button type="submit" name="update" class="btn btn-warning">Actualizar</button>
    </form>

    <h2 class="mt-4">Eliminar Proveedor</h2>
    <form method="post" action="proveedor.php">
        <div class="form-group">
            <label for="idProveedor">ID proveedor:</label>
            <input type="text" class="form-control" id="idProveedor" name="idProveedor" required>
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
