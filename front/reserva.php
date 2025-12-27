<?php
include("inc/conexion_bd.php");
include("inc/header.php");

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$pista_id = $_POST['pista_id'];

$sql = "SELECT * FROM pistas WHERE id = ".$pista_id.";";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>

<div>
    <p>Reservar la pista de <?= $fila['deporte'] ?> de <?= $hora ?> a <?= $hora + 1 ?>:00 el <?= $fecha ?></p>
    
    <form action="controladores/procesa_reserva.php" method="POST">
        <input type="hidden" name="pista_id" value="<?= $pista_id ?>">
        <input type="hidden" name="fecha" value="<?= $fecha ?>">
        <input type="hidden" name="hora" value="<?= $hora ?>">
        <input type="submit" value="Reservar">
    </form>
</div>

<?php
include("inc/footer.php");
?>
