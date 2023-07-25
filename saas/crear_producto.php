<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_producto = $_POST["nombre_producto"];
    $proveedor = $_POST["proveedor"];
    $cantidad = $_POST["cantidad"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $fecha_vencimiento = $_POST["fecha_vencimiento"];
    $lote = $_POST["lote"];
    $tipo_farmaceutico = $_POST["tipo_farmaceutico"];
    $personal_ingreso = $_POST["personal_ingreso"];

    if ($_FILES["imagen_producto"]["error"] === 0) {
        $imagen_temporal = $_FILES["imagen_producto"]["tmp_name"];
        $imagen_nombre = $_FILES["imagen_producto"]["name"];
        $ruta_imagen = "/carpeta_imagenes" . $imagen_nombre;
        move_uploaded_file($imagen_temporal, $ruta_imagen);

    } else {
        $ruta_imagen = "/carpeta_imagenes/pills.png";
    }

    $sql = "INSERT INTO productos (nombre_producto, proveedor, cantidad, fecha_ingreso, fecha_vencimiento, lote, tipo_farmaceutico, personal_ingreso, ruta_imagen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssissssss",
        $nombre_producto,
        $proveedor,
        $cantidad,
        $fecha_ingreso,
        $fecha_vencimiento,
        $lote,
        $tipo_farmaceutico,
        $personal_ingreso,
        $ruta_imagen
    );
    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "Producto creado correctamente.";
        header("Location: leer_productos.php");
        exit();
    } else {
        $_SESSION["error"] = "Error al crear el producto: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">

    <div class="text-center">
        <img src="carpeta_imagenes/logo.png" class="rounded img-fluid" alt="">

        <h2>Añadir Producto</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre_producto">Nombre del Farmaco:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor">
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad de Medicamentos (En Cajas):</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>
            <div class="form-group">
                <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
            </div>
            <div class="form-group">
                <label for="lote">Numero de El/Los Lotes:</label>
                <input type="number" class="form-control" id="lote" name="lote">
            </div>
            <div class="form-group">
                <label for="tipo_farmaceutico">Tipo Farmaco:</label>
                <input type="text" class="form-control" id="tipo_farmaceutico" name="tipo_farmaceutico">
            </div>
            <div class="form-group">
                <label for="personal_ingreso">Personal que lo ingresa:</label>
                <input type="text" class="form-control" id="personal_ingreso" name="personal_ingreso">
            </div>
            <div class="form-group">
                <label for="imagen_producto">Imagen del Producto:</label>
                <input type="file" class="form-control" id="imagen_producto" name="imagen_producto" accept="image/*">
            </div>
            <br>
            <button type="submit" class="btn btn-outline-success">Guardar Producto</button>
            <br>
            <br>
        </form>
    </div>
</body>
</html>
