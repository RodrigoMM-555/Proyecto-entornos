<?php
include("inc/conexion_bd.php");
include("inc/header.php");

    $sql = "SELECT * FROM polideportivos;";

    $resultado = $conexion->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
?>
    <article>
        <img src="" alt="Placeholder">
        <div>
            <h3><?= $fila['nombre'] ?></h3>
            <p><?= $fila['direccion'] ?></p>
            <a href="polideportivos.php?id=<?= $fila['id'] ?>">Ver mas</a>
        </div>
    </article>
<?php
    }
    $conexion->close();

include("inc/footer.php");
?>

<style>
    article{
        justify-content: center;
        text-align: center;
        display: flex;
        flex-direction: row;
        margin: 30px;
    }
    article div{
        margin-left: 20px;
        display: flex;
        flex-direction: column;
    }
    article div a{
        text-decoration: none;
        color: #2f4f3a;
        padding: 8px 18px;
        border-radius: 20px;
        transition: all 0.3s ease;
        background-color: transparent;
    }
    article div a:hover {
        background-color: #8bc6a8;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>