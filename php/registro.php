<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $tipo = $_POST['tipo']; //  ingreso de entrada o salida

    // Verificar si la cédula existe
    $sql = "SELECT id FROM empleado WHERE cedula = '$cedula'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $empleado_id = $row['id'];
        $fecha = date('Y-m-d'); // Usa la fecha actual del sistema
        $hora = date('H:i:s'); // Usa la hora actual del sistema

        // Verificar si ya existe un registro de entrada para hoy
        if ($tipo == 'entrada') {
            $sql = "SELECT * FROM asistencia WHERE empleado_id = $empleado_id AND fecha = '$fecha' AND hora_entrada IS NOT NULL";
            $checkResult = $conn->query($sql);

            if ($checkResult->num_rows > 0) {
                echo "Error: Ya existe un registro de entrada para hoy";
            } else {
                $sql = "INSERT INTO asistencia (empleado_id, fecha, hora_entrada) VALUES ($empleado_id, '$fecha', '$hora')";
                if ($conn->query($sql) === TRUE) {
                    echo "Registro de entrada exitoso";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } elseif ($tipo == 'salida') {
            $sql = "UPDATE asistencia SET hora_salida='$hora' WHERE empleado_id=$empleado_id AND fecha='$fecha'";
            if ($conn->query($sql) === TRUE) {
                echo "Registro de salida exitoso";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: La cédula no existe";
    }
}
?>
