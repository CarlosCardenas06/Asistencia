<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];

    // Se verifica si la cédula existe
    $sql = "SELECT id FROM empleado WHERE cedula = '$cedula'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Error: La cédula ya existe";
    } else {
        $sql = "INSERT INTO empleado (cedula, telefono, nombre, apellido, cargo) 
                VALUES ('$cedula', '$telefono', '$nombre', '$apellido', '$cargo')";
        if ($conn->query($sql) === TRUE) {
            echo "Empleado agregado exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
