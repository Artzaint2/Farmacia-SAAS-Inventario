<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $password);
    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
    } else {
        $_SESSION["error"] = "Error al registrar el usuario: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container">
    <div class="text-center">
        <img src="carpeta_imagenes/logo.png" class="rounded img-fluid" alt="">
      </div>
      <br>
        <h2 class="text-center">Registro de usuarios</h2>
        <div class="text-center">
                <img src="carpeta_imagenes/register.png" alt="" class="img-fluid">
            </div>
        <?php
        if (isset($_SESSION["mensaje"])) {
            echo '<div class="alert alert-success">' . $_SESSION["mensaje"] . '</div>';
            unset($_SESSION["mensaje"]);
        }
        if (isset($_SESSION["error"])) {
            echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
            unset($_SESSION["error"]);
        }

        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <br>
            </div>
            <div class="text-center">
        <button type="submit" class="btn btn-outline-success btn-lg">Registrarse</button>
        </div>
        </form>

        <br>

        <h2 class="text-center">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></h2>
    </div>

</body>
</html>
