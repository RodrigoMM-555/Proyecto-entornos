<table>
    <?php
        $resultado = $conexion->query("
        SELECT * FROM ".$_GET['tabla']." LIMIT 1;
        ");
        while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        foreach($fila as $clave=>$valor){
            echo "<th>".$clave."</th>";
        }
        echo "</tr>";
        }
    ?>
    <?php
        $resultado = $conexion->query("
        SELECT * FROM ".$_GET['tabla'].";
        ");
        while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        foreach($fila as $clave=>$valor){
            echo "<td>".$valor."</td>";
        }
        echo "</tr>";
        }
    ?>
</table>

<a href="?operacion=insertar&tabla=<?= $_GET['tabla'] ?>" class="boton_insertar">+</a>
<style>
    .boton_insertar{
        position:absolute;
        bottom:20px;
        right:20px;
        background:gold;
        border-radius:30px;
        width:30px;
        height:30px;
        color:white;
        text-align:center;
        line-height:30px;
        text-decoration:none;
    }
</style>
