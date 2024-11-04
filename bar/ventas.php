<?php
include 'db.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idProducto = $_POST['idProducto'];
    $cantidadV = $_POST['cantidadV'];
    $fecha = $_POST['fecha'];

    // Obtener el precio del producto
    $queryPrecio = "SELECT precio FROM productos WHERE idProducto = ?";
    $stmtPrecio = $conn->prepare($queryPrecio);
    $stmtPrecio->bind_param("i", $idProducto);
    $stmtPrecio->execute();
    $resultPrecio = $stmtPrecio->get_result();

    if ($rowPrecio = $resultPrecio->fetch_assoc()) {
        $precioUnitario = $rowPrecio['precio'];

        // Calcular el precio total
        $precioT = $precioUnitario * $cantidadV;

        // Insertar la venta
        $query = "INSERT INTO ventas (idProducto, cantidadV, fecha, precioT) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisd", $idProducto, $cantidadV, $fecha, $precioT);

        if ($stmt->execute()) {
            // Redirigir a la misma página después de registrar la venta
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Asegurarse de que el script se detenga después de la redirección
        } else {
            echo "Error al registrar la venta: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: No se encontró el producto.";
    }

    $stmtPrecio->close();
}

// Obtener productos para el menú desplegable
$result1 = $conn->query("SELECT idProducto, nombreProd FROM productos");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Registrar Venta</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="idProducto">Producto:</label>
                <select name="idProducto" id="idProducto" class="form-control" required>
                    <option value="">Selecciona un producto</option>
                    <?php while ($row = $result1->fetch_assoc()) { ?>
                        <option value="<?php echo $row['idProducto']; ?>"><?php echo $row['nombreProd']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cantidadV">Cantidad:</label>
                <input type="number" name="cantidadV" id="cantidadV" class="form-control" required min="1">
            </div>

            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
