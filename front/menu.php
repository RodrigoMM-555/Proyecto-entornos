<?php
include("inc/conexion_bd.php");
include("inc/header.php");

//Hay que crear un for para mostrar todos los polideportivos que hya en la BBDD
    $conexion = new mysqli($host, $user, $pass, $db);

    $sql = "SELECT * FROM producto;";

    $resultado = $conexion->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
?>
    <article>
        <div class="imagen"></div>
        <h3><?= $fila['nombre'] ?></h3>
        <p><?= $fila['direccion'] ?></p>
        <a href="polideportivo.php?id=<?= $fila['id'] ?>">Comprar</a>
    </article>
<?php
    }
    $conexion->close();

include("inc/footer.php");
?>