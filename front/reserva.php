
<!-- Paso intermedio para confirmar reserva -->
<?php
include("inc/conexion_bd.php");
include("inc/header.php");

$horario = $_POST['horario'];
$pista_id = $_POST['pista_id'];

$sql = "SELECT * FROM pistas WHERE id = ".$pista_id.";";

$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();

?>

<div>
    <p>Reservar la pista de <?= $fila['deporte']?> de <?= $horario ?> a <?= $horario + 1 ?>:00</p>
    <form action="confirmar_reserva.php" method="POST">
        <input type="hidden" name="horario" value="<?= $horario ?>">
        <input type="hidden" name="pista_id" value="<?= $pista_id ?>">
        <input type="submit" value="Reservar">
    </form>
</div>

<?php
include("inc/footer.php");
?>
