<?php
include("../inc/conexion_bd.php");

session_start();

$pista_id = $_POST['pista_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fecha_hora = $fecha . ' ' . $hora . ":00";

// Verificar si ya existe una reserva
$stmt = $conexion->prepare("SELECT id FROM reservas WHERE pista_id = ? AND fecha_hora = ? LIMIT 1");
$stmt->bind_param("is", $pista_id, $fecha_hora);
$stmt->execute();
$stmt->store_result();

//Confirma o no la reserva
$confirmacion = 'exito';
if ($stmt->num_rows > 0) {
    $confirmacion = 'error';

//En caso de confirmar
} else {
    // Obtener usuario
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION["usuario"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    $usuario_id = $fila['id'];

    // Insertar reserva
    $sql = "INSERT INTO reservas VALUES (NULL, $usuario_id, $pista_id, '$fecha_hora')";
    $conexion->query($sql);
}

// Formulario autoenviado
echo '
<form id="autoForm" action="../reserva.php?confirmacion='.$confirmacion.'" method="POST">
    <input type="hidden" name="pista_id" value="'.$pista_id.'">
    <input type="hidden" name="fecha" value="'.$fecha.'">
    <input type="hidden" name="hora" value="'.$hora.'">
</form>
<script>
    document.getElementById("autoForm").submit();
</script>';
exit;
?>
