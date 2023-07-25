<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre, $stored_password);
        $stmt->fetch();

        if ($password === $stored_password) {
            $_SESSION["usuario_id"] = $id;
            $_SESSION["usuario_nombre"] = $nombre;
            header("Location: leer_productos.php");
        } else {
            $_SESSION["error"] = "Contraseña incorrecta";
        }
    } else {
        $_SESSION["error"] = "No se encontró ninguna cuenta con ese email";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
    <div class="text-center">
        <img src="carpeta_imagenes/logo.png" class="rounded img-fluid" alt="">
      </div>
      <br>
        <h2 class="text-center">Iniciar sesión</h2>
            <div class="text-center">
                <img src="carpeta_imagenes/login.png" alt="" class="img-fluid">
            </div>
        <?php
        if (isset($_SESSION["error"])) {
            echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
            unset($_SESSION["error"]);
        }
        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <br>
            <div class="text-center">
        <button type="submit" class="btn btn-outline-success btn-lg">Iniciar sesión</button>
            </div>
        </form>
        <br>
        <h2 class="text-center">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></h2>
    </div>
</body>
</html>
