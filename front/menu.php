<?php
include("inc/conexion_bd.php");
include("inc/header.php");

$c = $_GET['c'];

    $sql = "SELECT * FROM polideportivos;";

    $resultado = $conexion->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
?>
    <article>
        <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
        <div>
            <h3><?= $fila['nombre'] ?></h3>
            <p><?= $fila['direccion'] ?></p>
            <a href="polideportivos.php?id=<?= $fila['id'] ?>&c=<?= $c ?>">Ver mas</a>
        </div>
    </article>
<?php
    }
    $conexion->close();

include("inc/footer.php");
?>


<style>
    main {
        background-color: #f6f7f3;
        padding: 30px 0;
    }

    article {
        display: flex;
        align-items: center;
        gap: 25px;
        max-width: 800px;
        margin: 25px auto;
        padding: 20px 25px;
        background-color: #f0f1e9;
        border-radius: 18px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    article img {
        width: 180px;
        height: 120px;
        object-fit: cover;
        border-radius: 14px;
        background-color: #d9e6dc;
    }

    article div {
        display: flex;
        flex-direction: column;
        gap: 10px;
        text-align: left;
    }

    article h3 {
        color: #2f4f3a;
        font-size: 1.4rem;
    }

    article p {
        color: #4f6b5a;
        font-size: 1rem;
        line-height: 1.4;
    }

    article div a {
        align-self: flex-start;
        margin-top: 10px;
        text-decoration: none;
        color: #2f4f3a;
        padding: 8px 20px;
        border-radius: 20px;
        background-color: transparent;
        border: 2px solid #8bc6a8;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    article div a:hover {
        background-color: #8bc6a8;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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

        article div a {
            align-self: center;
        }
    }
</style>