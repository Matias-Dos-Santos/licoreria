<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear producto
    if (isset($_POST['create'])) {
        $nombreProd = $_POST['nombreProd'] ?? null;
        $marca = $_POST['marca'] ?? null;
        $precio = $_POST['precio'] ?? null;
        $cantidad = $_POST['cantidad'] ?? null;
        $tipoBebida = $_POST['tipoBebida'] ?? null;
        $idProveedor = $_POST['idProveedor'] ?? null;

        if ($nombreProd && $marca && $precio && $cantidad && $tipoBebida && $idProveedor) {
            $stmt = $conn->prepare("INSERT INTO productos (nombreProd, marca, precio, cantidad, tipoBebida, idProveedor) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssddsi", $nombreProd, $marca, $precio, $cantidad, $tipoBebida, $idProveedor);

            if ($stmt->execute()) {
                echo "Producto registrado exitosamente<br>";
            } else {
                echo "Error al registrar el producto: " . $stmt->error . "<br>";
            }
            $stmt->close();
        } else {
            echo "Por favor completa todos los campos requeridos.<br>";
        }
    }

    // Actualizar producto
    if (isset($_POST['update'])) {
        $idProducto = $_POST['idProducto'];
        $nombreProd = $_POST['nombreProd'];
        $marca = $_POST['marca'];
        $precio = $_POST['precio'];
        $cantidad = $_POST['cantidad'];
        $tipoBebida = $_POST['tipoBebida'];

        $stmt = $conn->prepare("UPDATE productos SET nombreProd = ?, marca = ?, precio = ?, cantidad = ?, tipoBebida = ? WHERE idProducto = ?");
        $stmt->bind_param("ssddsi", $nombreProd, $marca, $precio, $cantidad, $tipoBebida, $idProducto);

        if ($stmt->execute()) {
            echo "Producto actualizado exitosamente<br>";
        } else {
            echo "Error al actualizar el producto: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    // Eliminar producto
    if (isset($_POST['delete'])) {
        $idProducto = $_POST['idProducto'];

        $stmt = $conn->prepare("DELETE FROM productos WHERE idProducto = ?");
        $stmt->bind_param("i", $idProducto);

        if ($stmt->execute()) {
            echo "Producto eliminado exitosamente<br>";
        } else {
            echo "Error al eliminar el producto: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

// Recuperar productos
$result1 = $conn->query("SELECT idProducto, nombreProd, marca, precio, cantidad, tipoBebida FROM productos");

// Recuperar proveedores
$idProveedor = $conn->query("SELECT idProveedor, nombreDist, telefono FROM proveedor");

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Licorería</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="pantalla_principal.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">Usuarios</a>
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
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-4">Productos Registrados</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre Producto</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Tipo de Bebida</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idProducto"] . "</td>";
                    echo "<td>" . $row["nombreProd"] . "</td>";
                    echo "<td>" . $row["marca"] . "</td>";
                    echo "<td>" . $row["precio"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>" . $row["tipoBebida"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
            } ?>
        </tbody>
    </table>
</div>

<div class="container">
    <h2 class="mt-4">Añadir Producto</h2>
    <form method="post" action="productos.php">
        <div class="form-group">
            <label for="nombreProd">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombreProd" name="nombreProd" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="tipoBebida">Tipo de Bebida:</label>
            <input type="text" class="form-control" id="tipoBebida" name="tipoBebida" required>
        </div>
        <div class="form-group">
            <label for="idProveedor">Proveedor:</label>
            <select class="form-control" id="idProveedor" name="idProveedor" required>
                <?php while ($row = $idProveedor->fetch_assoc()): ?>
                    <option value="<?php echo $row['idProveedor']; ?>"><?php echo $row['nombreDist']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="create" class="btn btn-primary">Añadir</button>
    </form>

    <h2 class="mt-4">Actualizar Producto</h2>
    <form method="post" action="productos.php">
        <div class="form-group">
            <label for="idProducto">ID del Producto:</label>
            <input type="number" class="form-control" id="idProducto" name="idProducto" required>
        </div>
        <div class="form-group">
            <label for="nombreProd">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombreProd" name="nombreProd" required>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="tipoBebida">Tipo de Bebida:</label>
            <input type="text" class="form-control" id="tipoBebida" name="tipoBebida" required>
        </div>
        <button type="submit" name="update" class="btn btn-warning">Actualizar</button>
    </form>

    <h2 class="mt-4">Eliminar Producto</h2>
    <form method="post" action="productos.php">
        <div class="form-group">
            <label for="idProducto">ID del Producto:</label>
            <input type="number" class="form-control" id="idProducto" name="idProducto" required>
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
