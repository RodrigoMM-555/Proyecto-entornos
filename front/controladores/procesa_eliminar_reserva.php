
<?php

include "../inc/conexion_bd.php";

$sql = "DELETE FROM reservas WHERE id=".$_GET['reserva_id'];
$conexion->query($sql);
header("Location: ../vista_reservas.php");

?>
