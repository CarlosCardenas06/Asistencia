<?php
require('pdf/fpdf.php');
include 'db_connection.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reporte de Asistencia Semanal', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));

$cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$apellido = isset($_GET['apellido']) ? $_GET['apellido'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

$sql = "SELECT empleado.cedula, empleado.nombre, empleado.apellido, asistencia.fecha, asistencia.hora_entrada, asistencia.hora_salida 
        FROM asistencia 
        JOIN empleado ON asistencia.empleado_id = empleado.id 
        WHERE fecha BETWEEN '$week_start' AND '$week_end'";

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

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Cedula', 1);
$pdf->Cell(40, 10, 'Nombre', 1);
$pdf->Cell(40, 10, 'Apellido', 1);
$pdf->Cell(25, 10, 'Fecha', 1);
$pdf->Cell(25, 10, 'Entrada', 1);
$pdf->Cell(25, 10, 'Salida', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['cedula'], 1);
        $pdf->Cell(40, 10, $row['nombre'], 1);
        $pdf->Cell(40, 10, $row['apellido'], 1);
        $pdf->Cell(25, 10, $row['fecha'], 1);
        $pdf->Cell(25, 10, $row['hora_entrada'], 1);
        $pdf->Cell(25, 10, $row['hora_salida'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay registros.', 1, 1, 'C');
}

$pdf->Output('D', 'reporte_asistencia_semanal.pdf');
?>
