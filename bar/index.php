<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Comparación directa de la contraseña
        if ($contraseña === $row['contraseña']) {
            $_SESSION['usuario'] = $usuario;
            header("Location: home.php");
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<body>
<style>
 body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            gap: 0.5em;
            border-radius: 25px;
            padding: 0.9em;
            border: none;
            outline: none;
            color: white;
            background-color: #171717;
            box-shadow: inset 2px 5px 10px rgb(5, 5, 5);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-control {
            border-radius: 9px;
        }
        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
        }
</style>
<div class="login-container">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <h2>Inicio de Sesión</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="form-group">
            <label for="usuario">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>
        </div>
        <div class="form-group">
            <label for="contraseña">Contraseña:</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingresa tu contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>
</div>
</body>
</html>
