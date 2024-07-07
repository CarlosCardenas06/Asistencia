<?php
include 'db_connection.php';

$fecha = date('Y-m-d');
$sql = "SELECT empleado.nombre, asistencia.fecha, asistencia.hora_entrada, asistencia.hora_salida 
        FROM asistencia 
        JOIN empleado ON asistencia.empleado_id = empleado.id 
        WHERE fecha='$fecha'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Nombre: " . $row["nombre"] . " - Fecha: " . $row["fecha"] . " - Entrada: " . $row["hora_entrada"] . " - Salida: " . $row["hora_salida"] . "<br>";
    }
} else {
    echo "0 results";
}
