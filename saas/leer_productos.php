<?php
session_start();
require_once "config.php";
$sql = "SELECT *, CONCAT(proveedor, ' - ', FLOOR(RAND() * 100000) + 100000) AS numero_control FROM productos";
$resultado = $conn->query($sql);
$productos = array();
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Farmacos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
    <div class="text-center">
        <img src="carpeta_imagenes/logo.png" class="rounded img-fluid" alt="">
      </div>
        <h2 class="text-center">Listado de Productos</h2>
        <br>
        <button onclick="generarReportePDF()" class="btn btn-outline-secondary">Descargar Reporte PDF</button>
        <br>
        <br>
        <table id="tabla_productos" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Farmaco</th>
                    <th>Proveedor / Número de Control</th>
                    <th>Cantidad de Medicamentos</th>
                    <th>Fecha de Ingreso</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Cantidad de Lotes</th>
                    <th>Tipo de Farmaco</th>
                    <th>Personal que lo ingresa</th>
                    <th>Imagen del Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <td><?php echo $producto["id"]; ?></td>
                        <td><?php echo $producto["nombre_producto"]; ?></td>
                        <td><?php echo $producto["numero_control"]; ?></td>
                        <td><?php echo $producto["cantidad"]; ?></td>
                        <td><?php echo $producto["fecha_ingreso"]; ?></td>
                        <td><?php echo $producto["fecha_vencimiento"]; ?></td>
                        <td><?php echo $producto["lote"]; ?></td>
                        <td><?php echo $producto["tipo_farmaceutico"]; ?></td>
                        <td><?php echo $producto["personal_ingreso"]; ?></td>
                        <td>
                            <?php if (!empty($producto["ruta_imagen"])) : ?>
                                <img src="<?php echo $producto["ruta_imagen"]; ?>" alt="Imagen del Producto" width="50">
                            <?php else : ?>
                                <img src="/" alt="">
                            <?php endif; ?>
                            <svg class="barcode" data-producto-id="<?php echo $producto["id"]; ?>"></svg>
                        </td>
                        <td>
                            <a href="actualizar_producto.php?id=<?php echo $producto["id"]; ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                            <br>
                            <br>
                            <a href="eliminar_producto.php?id=<?php echo $producto["id"]; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        <a href="crear_producto.php" class="btn btn-outline-success">Agregar Producto</a>
        <br>
        <br>
        <a href="logout.php">Cerrar sesión</a>
                <br>
                <br>
        <h2>Gráfica de Cantidad de Medicamentos por Tipo de Farmaco</h2>
        <canvas id="grafica_cantidad_tipo_farmac" width="400" height="200"></canvas>
        <br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabla_productos').DataTable();
        });
        </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    function generarReportePDF() {
        document.querySelector('h2:nth-of-type(2)').style.display = 'none';
        document.getElementById('grafica_cantidad_tipo_farmac').style.display = 'none'; 
        const content = document.querySelector('.container').cloneNode(true);
        document.getElementById('grafica_cantidad_tipo_farmac').style.display = 'block';
        const options = {
            margin: 1,
            filename: 'reporte.pdf',
            image: { type: 'png', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'c2' },
        };

        html2pdf().from(content).set(options).save();
    }
</script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    <?php
    $tipos_farmaceuticos = array();
    $cantidades_por_tipo = array();
    foreach ($productos as $producto) {
        $tipo_farmaceutico = $producto["tipo_farmaceutico"];
        $cantidad = $producto["cantidad"];
        if (isset($cantidades_por_tipo[$tipo_farmaceutico])) {
            $cantidades_por_tipo[$tipo_farmaceutico] += $cantidad;
        } else { 
            $cantidades_por_tipo[$tipo_farmaceutico] = $cantidad;
        }
    }

    ?>
    var ctxCantidadTipoFarmac = document.getElementById('grafica_cantidad_tipo_farmac').getContext('2d');
    var graficaCantidadTipoFarmac = new Chart(ctxCantidadTipoFarmac, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($cantidades_por_tipo)); ?>,
            datasets: [{
                label: 'Cantidad de Medicamentos por Tipo de Farmacéutico',
                data: <?php echo json_encode(array_values($cantidades_por_tipo)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
       
            });
    </script>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productosConCodigoBarras = document.querySelectorAll('.barcode');
        productosConCodigoBarras.forEach(producto => {
            const productoId = producto.getAttribute('data-producto-id');
            const codigoBarras = Math.random().toString().substr(2, 12); 

            JsBarcode(producto, codigoBarras, {
                displayValue: true, 
                fontSize: 12,
            });
        });
    });
</script>

</body>
</html>