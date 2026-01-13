<?php
include("inc/conexion_bd.php");
include("inc/header.php");

session_start();

// Obtener el id de usuario
$stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $_SESSION["usuario"]);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
$usuario_id = $fila['id'];

//Obtenemos las reservas del ususario
$sql = "SELECT * FROM reservas WHERE usuario_id =".$usuario_id.";";
$resultado = $conexion->query($sql);
    //De cada reserva queremos los siguientes datos
    while ($fila = $resultado->fetch_assoc()) {
        //ID de la pista y la fehca y hora de la reserva
        $reserva_id = $fila["id"];
        $pista_id = $fila["pista_id"];
        $fecha_hora = $fila["fecha_hora"];
        //Con la id de la pista pedimos informacion sobre la misma y la ID de su polideportivo
        $sqlpi = "SELECT * FROM pistas WHERE id=".$pista_id.";";
        $resultadopi = $conexion->query($sqlpi);
        $filapi = $resultadopi->fetch_assoc();
        $polideportivo_id = $filapi["polideportivo_id"];
        $deporte = $filapi["deporte"];
        $caracteristicas = $filapi["caracteristicas"];
        $max_personas = $filapi["max_personas"];
        $precio = $filapi["precio"];
        //Con la ID del polideportivo sacamos su nombre y direccion
        $sqlp = "SELECT * FROM polideportivos WHERE id=".$polideportivo_id.";";
        $resultadop = $conexion->query($sqlp);
        $filap = $resultadop->fetch_assoc();
        $polideportivo_nombre = $filap["nombre"];
        $polideportivo_direccion = $filap["direccion"];

?>
    <!-- Por ultimo por cada reserva pintamos un article -->
    <article>
            <h3><?= $polideportivo_nombre ?><a href="controladores/procesa_eliminar_reserva.php?reserva_id=<?= $reserva_id ?>">❌</a></h3>
            <p>Direccion: <?= $polideportivo_direccion ?></p>
            <h2><?= $deporte ?></h2>
            <p><?= $caracteristicas ?></p>
            <p>Maximo de personas: <?= $max_personas ?></p>
            <p>Precio: <?= $precio ?>€/hora</p>
            <p><?= $fecha_hora ?></p>
    </article>

<?php
    }
    $conexion->close();

include("inc/footer.php");
?>


<style>
    main {
        background-color: #f6f7f3;
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(3,1fr);
        justify-items: center;

    }

    article {
        display: flex;
        max-width: 500px;
        padding: 20px 25px;
        background-color: #f0f1e9;
        border-radius: 18px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        flex-direction: column;
        margin-top: 10px;
        gap: 10px;
        text-align: left;

    }

    article:hover{
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);

    }

    article h3 {
        display: flex;
        justify-content: space-between;
        color: #2f4f3a;
        font-size: 1.4rem;
    }
    article h3 a {
        text-decoration: none;
    }

    article p {
        color: #4f6b5a;
        font-size: 1rem;
        line-height: 1.4;
    }

    /* Responsive */
    @media (max-width: 700px) {
        article {
            flex-direction: column;
            text-align: center;
        }

        article div {
            align-items: center;
            text-align: center;
        }

    }
</style>