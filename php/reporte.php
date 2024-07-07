<?php
include 'db_connection.php';

// Obtener valores de los filtros si están establecidos
$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));

$sql = "SELECT empleado.cedula, empleado.nombre, empleado.apellido, asistencia.fecha, asistencia.hora_entrada, asistencia.hora_salida 
        FROM asistencia 
        JOIN empleado ON asistencia.empleado_id = empleado.id 
        WHERE fecha BETWEEN '$week_start' AND '$week_end'";

// Agregar filtros a la consulta
if ($cedula) {
    $sql .= " AND empleado.cedula LIKE '%$cedula%'";
}
if ($nombre) {
    $sql .= " AND empleado.nombre LIKE '%$nombre%'";
}
if ($apellido) {
    $sql .= " AND empleado.apellido LIKE '%$apellido%'";
}
if ($fecha) {
    $sql .= " AND asistencia.fecha = '$fecha'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencia Semanal</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .filter-form {
            margin-bottom: 20px;
        }
        .filter-form input {
            padding: 10px;
            margin-right: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .filter-form button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filter-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Asistencia Semanal</h1>
        <form class="filter-form" method="GET" action="reporte.php">
            <input type="text" name="cedula" placeholder="Cédula" value="<?php echo htmlspecialchars($cedula); ?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            <input type="text" name="apellido" placeholder="Apellido" value="<?php echo htmlspecialchars($apellido); ?>">
            <input type="date" name="fecha" placeholder="Fecha" value="<?php echo htmlspecialchars($fecha); ?>">
            <button type="submit">Filtrar</button>
        </form>
        <form method="GET" action="generar_reporte_pdf.php">
            <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($cedula); ?>">
            <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            <input type="hidden" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>">
            <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
            <button type="submit">Descargar PDF</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha</th>
                    <th>Hora de Entrada</th>
                    <th>Hora de Salida</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['cedula']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['apellido']}</td>
                                <td>{$row['fecha']}</td>
                                <td>{$row['hora_entrada']}</td>
                                <td>{$row['hora_salida']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay registros.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
