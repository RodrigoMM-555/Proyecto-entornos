<?php
include("inc/conexion_bd.php");
include("inc/header.php");
?>
<div>
    <!-- Seccion izquierda -->
    <section class="izquierda">
        <?php
            $sql = "SELECT * FROM polideportivos WHERE id = ".$_GET['id'].";";

            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()) {
        ?>

        <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
        <div>
            <h3><?= $fila['nombre'] ?></h3>
            <p><?= $fila['direccion'] ?></p>
        </div>

        <?php
        }
        ?>

    </section>

    <!-- Seccion derecha -->
    <section class="derecha">
        <!-- Conexion -->
        <?php
            $sql = "SELECT * FROM pistas WHERE polideportivo_id = ".$_GET['id'].";";

            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()) {
        ?>
        <!-- Articulos -->
        <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
        <div>
            <h3>Pista de <?= $fila['deporte'] ?></h3>
            <p>Precio: <?= $fila['precio'] ?>€/hora</p>

            <form action="reserva.php" method="POST">
                <?php
                for ($i = 8; $i <= 19; $i++) {
                    echo "
                        <input type='submit' name='horario' value='".$i.":00'>
                        <input type='hidden' name='pista_id' value='".$fila['id']."'>
                    ";
                    }
                ?>
            </form>

        </div>
        <p><?= $fila['caracteristicas'] ?></p>
        <!-- Cierre de conexion -->
        <?php
        }
        $conexion->close();
        ?>
    </section>
</div>
<?php
include("inc/footer.php");
?>

<style>
    main div{
        display: flex;
        justify-content: center;
        padding: 40px 20px;
    }
    .izquierda {
        flex: 2;
        margin-left: 80px;
        background: #6ca186ff;
        display: flex;
        flex-direction: column;
    }
    .derecha {
        flex: 5;
        margin-right: 80px;
    }
    .derecha div{
        display: flex;
        flex-direction: row;
        margin-bottom: 30px;
    }
</style>