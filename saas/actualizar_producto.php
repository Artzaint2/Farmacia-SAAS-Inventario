<?php
session_start();
require_once "config.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: leer_productos.php");
    exit();
}
$id_producto = $_GET["id"];

$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    header("Location: leer_productos.php");
    exit();
}

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
        $ruta_imagen = "carpeta_imagenes/" . $imagen_nombre;
        move_uploaded_file($imagen_temporal, $ruta_imagen);
    } else {
        $ruta_imagen = $producto["ruta_imagen"];
    }

    $sql = "UPDATE productos SET nombre_producto = ?, proveedor = ?, cantidad = ?, fecha_ingreso = ?, fecha_vencimiento = ?, lote = ?, tipo_farmaceutico = ?, personal_ingreso = ?, ruta_imagen = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssissssssi",
        $nombre_producto,
        $proveedor,
        $cantidad,
        $fecha_ingreso,
        $fecha_vencimiento,
        $lote,
        $tipo_farmaceutico,
        $personal_ingreso,
        $ruta_imagen,
        $id_producto
    );

    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "Producto actualizado correctamente.";
        header("Location: leer_productos.php");
        exit();
    } else {
        $_SESSION["error"] = "Error al actualizar el producto: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">
    <div class="text-center">
        <img src="carpeta_imagenes/logo.png" class="rounded img-fluid" alt="">

        <h2>Actualizar Informacion</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre_producto">Nombre del Farmaco:</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?php echo $producto["nombre_producto"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="proveedor">Proveedor:</label>
                <input type="text" class="form-control" id="proveedor" name="proveedor" value="<?php echo $producto["proveedor"]; ?>">
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad de Medicamentos (en cajas):</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $producto["cantidad"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $producto["fecha_ingreso"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $producto["fecha_vencimiento"]; ?>" required>
            </div>
            <div class="form-group">
                <label for="lote">Cantidad de Lotes:</label>
                <input type="number" class="form-control" id="lote" name="lote" value="<?php echo $producto["lote"]; ?>">
            </div>
            <div class="form-group">
                <label for="tipo_farmaceutico">Tipo de Farmaco:</label>
                <input type="text" class="form-control" id="tipo_farmaceutico" name="tipo_farmaceutico" value="<?php echo $producto["tipo_farmaceutico"]; ?>">
            </div>
            <div class="form-group">
                <label for="personal_ingreso">Personal que lo ingresa:</label>
                <input type="text" class="form-control" id="personal_ingreso" name="personal_ingreso" value="<?php echo $producto["personal_ingreso"]; ?>">
            </div>
            <div class="form-group">
                <label for="imagen_producto">Imagen del Producto:</label>
                <input type="file" class="form-control" id="imagen_producto" name="imagen_producto" accept="image/*">
            </div>
            <br>
            <button type="submit" class="btn btn-outline-success">Actualizar Producto</button>
            <br>
            <br>
        </form>
    </div>
</body>
</html>
