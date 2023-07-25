<?php
session_start();
require_once "config.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: leer_productos.php");
    exit();
}

$id_producto = $_GET["id"];

$sql = "SELECT id FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    header("Location: leer_productos.php");
    exit();
}

$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);

if ($stmt->execute()) {
    $_SESSION["mensaje"] = "Producto eliminado correctamente.";
} else {
    $_SESSION["error"] = "Error al eliminar el producto: " . $conn->error;
}

header("Location: leer_productos.php");
exit();
?>
