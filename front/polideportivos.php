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

        <img src="" alt="Placeholder">
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
        <img src="" alt="Placeholder">
        <div>
            <h3>Pista de <?= $fila['deporte'] ?></h3>
            <p>Precio: <?= $fila['precio'] ?>€/hora</p>

            <form action="reservar.php" method="POST">
            <select multiple name="horario">
                <?php
                for ($i = 8; $i <= 20; $i++) {
                    echo "
                <label>
                    <input type='radio' name='horario' value='".$i.":00'>
                    <span>".$i.":00</span>
                </label>";
                }
                ?>
            </select>
            <button type="submit">Reservar</button>
        </form>

        </div>
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