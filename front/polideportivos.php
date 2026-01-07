<?php
include("inc/conexion_bd.php");
include("inc/header.php");

$c = $_GET['c'];

?>
<div>
    <!-- Seccion izquierda -->
    <section class="izquierda">
        <?php
            $sql = "SELECT * FROM polideportivos WHERE id = ".$_GET['id'].";";

            $resultado = $conexion->query($sql);
            $fila = $resultado->fetch_assoc();
        ?>

        <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
        <div>
            <h3><?= $fila['nombre'] ?></h3>
            <p><?= $fila['direccion'] ?></p>
        </div>


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

            <form action="reserva.php?c=<?= $c ?>" method="POST">
                <!-- Campo para seleccionar la fecha -->
                <label for="fecha">Selecciona la fecha:</label>
                <input type="date" name="fecha" required>

                <?php
                for ($i = 8; $i <= 19; $i++) {
                    echo "
                        <input type='submit' name='hora' value='".$i.":00'>
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
    main {
        background-color: #f6f7f3;
    }

    main > div {
        display: flex;
        gap: 40px;
        max-width: 1200px;
        margin: auto;
        padding: 40px 20px;
    }

    /* ---------- SECCIÓN IZQUIERDA ---------- */
    .izquierda {
        flex: 2;
        background-color: #f0f1e9;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        display: flex;
        flex-direction: column;
        gap: 15px;
        height: fit-content;
    }

    .izquierda img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 14px;
        background-color: #d9e6dc;
    }

    .izquierda h3 {
        color: #2f4f3a;
        font-size: 1.5rem;
    }

    .izquierda p {
        color: #4f6b5a;
        font-size: 1rem;
    }

    /* ---------- SECCIÓN DERECHA ---------- */
    .derecha {
        flex: 5;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* CADA PISTA ES UNA CARD COMPLETA */
    .derecha > img,
    .derecha > div,
    .derecha > p {
        margin: 0;
    }

    .derecha > img {
        display: none; /* ocultamos imagen suelta */
    }

    .derecha > p {
        display: none; /* ocultamos descripción suelta */
    }

    /* CARD COMPLETA DE PISTA */
    .derecha > div {
        background-color: #f0f1e9;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        display: flex;
        flex-direction: column;
        gap: 15px;
        position: relative;
    }

    /* Imagen dentro de la card */
    .derecha div img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 14px;
        background-color: #d9e6dc;
    }

    .derecha h3 {
        color: #2f4f3a;
        font-size: 1.4rem;
    }

    .derecha p {
        color: #4f6b5a;
        font-size: 1rem;
    }

    /* ---------- FORMULARIO ---------- */
    form {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    form label {
        width: 100%;
        color: #2f4f3a;
        font-weight: 500;
    }

    form input[type="date"] {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #b2cdab;
        outline: none;
    }

    form input[type="submit"] {
        padding: 6px 14px;
        border-radius: 16px;
        border: 2px solid #8bc6a8;
        background-color: transparent;
        color: #2f4f3a;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    form input[type="submit"]:hover {
        background-color: #8bc6a8;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 900px) {
        main > div {
            flex-direction: column;
        }
    }
</style>



<!-- 

Estilo alternativo anterior

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
 -->