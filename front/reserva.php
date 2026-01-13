<?php
include("inc/conexion_bd.php");
include("inc/header.php");


$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$pista_id = $_POST['pista_id'];

$sql = "SELECT * FROM pistas WHERE id = ".$pista_id.";";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();

$hora_num = (int)explode(':', $hora)[0];  // Extraemos solo la hora numérica
?>

<p>Reservar la pista de <?= $fila['deporte'] ?> de <?= $hora_num ?> a <?= $hora_num + 1 ?>:00 el <?= $fecha ?></p>
<p class="confirmacion"><?= $texto_confirmacion ?></p>

<form action="controladores/procesa_reserva.php" method="POST">
    <input type="hidden" name="pista_id" value="<?= $pista_id ?>">
    <input type="hidden" name="fecha" value="<?= $fecha ?>">
    <input type="hidden" name="hora" value="<?= $hora ?>">
    <input type="submit" value="Reservar">
</form>


<style>
    main {
        background:#f6f7f3;
        text-align: center;
    }

</style>

<?php
if (isset($_GET['confirmacion'])) {
    if ($_GET['confirmacion'] == 'exito') {
        echo "
        <script>document.querySelector('.confirmacion').innerText = 'Reserva realizada con éxito.';
        document.querySelector('.confirmacion').style.color = 'green';</script>
        ";
        
    } elseif ($_GET['confirmacion'] == 'error') {
        echo "
        <script>document.querySelector('.confirmacion').innerText = 'Error al realizar la reserva. Inténtalo de nuevo.';
        document.querySelector('.confirmacion').style.color = 'red';</script>
        ";
    }
} else {
    echo "<script>document.querySelector('.confirmacion').innerText = '';</script>";
}  

include("inc/footer.php");
?>

<style>
    form input[type="submit"] {
        align-self: flex-start;
        margin-top: 10px;
        text-decoration: none;
        color: #2f4f3a;
        padding: 8px 20px;
        border-radius: 20px;
        background-color: #f0f1e9;
        border: 2px solid #8bc6a8;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    form input[type="submit"]:hover {
        background-color: #8bc6a8;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
</style>