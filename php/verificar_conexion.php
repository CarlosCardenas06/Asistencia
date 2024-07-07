<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebahospital";

// Creación de conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos '$dbname'.<br>";
}

// Consulta Prueba
$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Tablas en la base de datos '$dbname':<br>";
    while ($row = $result->fetch_assoc()) {
        echo $row['Tables_in_' . $dbname] . "<br>";
    }
} else {
    echo "No se encontraron tablas en la base de datos.";
}

$conn->close();
