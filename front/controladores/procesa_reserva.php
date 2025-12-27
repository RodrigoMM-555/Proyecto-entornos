<?php
include("../inc/conexion_bd.php");

$pista_id = $_POST['pista_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fecha_hora = $fecha . ' ' . $hora . ":00";

// Verificar si ya existe una reserva para esa pista y hora
$sql = "SELECT id FROM reservas WHERE pista_id = ? AND fecha_hora = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("is", $pista_id, $fecha_hora);
$stmt->execute();
$stmt->store_result();  // Almacenamos el resultado para saber cuántos registros hay

// Si ya existe una reserva, redirigimos con un error
if ($stmt->num_rows > 0) {
    echo "La pista ya está reservada para esa fecha y hora.";
    exit;
}

// Si no hay conflicto, procedemos a insertar la nueva reserva
$sql = "INSERT INTO reservas VALUES (
    NULL,
    1,
    ".$pista_id.",
    '".$fecha_hora."'
    );";

$resultado = $conexion->query($sql);

// Redirigir a la página de éxito
echo "Reserva realizada con éxito.";
exit;
?>
