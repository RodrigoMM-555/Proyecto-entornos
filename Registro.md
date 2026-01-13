# Reporte de proyecto

## Estructura del proyecto

```
/home/RodrigoMenendez/Desktop/Proyecto-entornos
├── BBDD
│   ├── base de datos.sql
│   └── usuarui.sql
├── back
│   ├── controladores
│   │   ├── insertar.php
│   │   ├── leer.php
│   │   ├── poblar_menu.php
│   │   └── procesainsertar.php
│   ├── css
│   │   └── estilo.css
│   ├── inc
│   │   └── conexion_bd.php
│   └── index.php
└── front
    ├── controladores
    │   ├── procesar_login.php
    │   └── procesar_registro.php
    ├── css
    │   └── estilo.css
    ├── inc
    │   ├── conexion_bd.php
    │   ├── footer.php
    │   └── header.php
    ├── index.php
    ├── menu.php
    └── registro.php
```

## Código (intercalado) ~560 Lineas de codigo

# Proyecto-entornos
## BBDD
**base de datos.sql**
```sql

CREATE DATABASE reserva_pistas;
USE reserva_pistas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE polideportivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL
);

--En revision: ¿una tabla general de pistas o una tabla por deporte?
CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    polideportivo_id INT,
    nombre VARCHAR(100) NOT NULL,
    deporte VARCHAR(50) NOT NULL,
    caracteristicas TEXT,
    FOREIGN KEY (polideportivo_id) REFERENCES polideportivos(id)
);


CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    pista_id INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (pista_id) REFERENCES pistas(id)
);


```
**usuarui.sql**
```sql

--Creamos ususario
CREATE USER 
'Ureserva_pistas'@'localhost' 
IDENTIFIED  BY 'Ureserva_pistas2$';
GRANT USAGE ON *.* TO 'Ureserva_pistas'@'localhost';
ALTER USER 'Ureserva_pistas'@'localhost' 
REQUIRE NONE
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON reserva_pistas.* 
TO 'Ureserva_pistas'@'localhost';
FLUSH PRIVILEGES;
```
## back
**index.php**
```php
<!doctype html>
<html>
	<head>
        <link rel="stylesheet" href="css/estilo.css">
    </head>
    <body>
        <?php include "inc/conexion_bd.php"; ?>
        <nav>
            <?php include "controladores/poblar_menu.php" ?>
        </nav>
        <main>
            <?php
                // Enrutador: se encarga de manejar las operaciones a mostrar
                if(!isset($_GET['operacion'])){ // Si no hay operacion
                    include "controladores/leer.php";
                }
                else{
                    if($_GET['operacion'] == "insertar"){
                        include "controladores/insertar.php";
                    }
                    else if($_GET['operacion'] == "procesainsertar"){
                        include "controladores/procesainsertar.php";
                    }
                }
            ?>
        </main>
    </body>
</html>
```
### controladores
**insertar.php**
```php
<form action="?operacion=procesainsertar&tabla=<?= $_GET['tabla'] ?>" method="POST">
<?php
        // CREAMOS UN FORMULARIO DINÁMICO
        $resultado = $conexion->query("
            SELECT * FROM ".$_GET['tabla']." LIMIT 1;
        ");	
        // SOLO QUIERO UN ELEMENTO !!!!!!!!!!!!!!!!
        while ($fila = $resultado->fetch_assoc()) {
            foreach($fila as $clave=>$valor){
            echo "
                <div class='control_formulario'>
                <label>".$clave."</label>
                <input 
                    type='text' 
                    name='".$clave."'
                    placeholder='".$clave."'>
                </div>
                ";
            }
        }
    ?>
    <div class="control_formulario">
        <label>Insertar</label>
        <input type="submit" value="Insertar">
    </div>
</form>
<style>
    form{
        width:100%;
        display:flex;
        flex-direction:column;
        gap:20px;
    }
    .control_formulario{
        display:flex;
    }
    label{
        flex:1;
    }
    input{
        flex:4;
        padding:10px;
        border:2px solid gold;
    }
    input[type="submit"]{
        background:gold;
        color:white;
        border:none;
        cursor:pointer;
    }
</style>





```
**leer.php**
```php
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

```
**poblar_menu.php**
```php
<?php
	// Ahora lo que quiero es un listado de las tablas en la base de datos
	$resultado = $conexion->query("
    SHOW TABLES;
    ");
    while ($fila = $resultado->fetch_assoc()) {
        $clase = "";							// De entrada no tienes clase	
        if($fila['Tables_in_'.$db] == $_GET['tabla']){	// Pero si el nombre de esta tabla coincide con la tabla cargada
            $clase  = "activo";			// En ese caso tu clase es "activo"
        }
        echo '
            <a href="?tabla='.$fila['Tables_in_'.$db].'" class="'.$clase.'">
            '.$fila['Tables_in_'.$db].'
        </a>
        ';
    }
?>
<style>
	.activo{
  	border: 2px solid #000;
  }
</style>
```
**procesainsertar.php**
```php
<?php
    $sql = "INSERT INTO ".$_GET['tabla']." VALUES (";	// Inicio el formateo del SQL
    foreach($_POST as $clave=>$valor){							// Recorro los campos del form
        if($clave == "id"){														// Si eres un id
            $sql.= "NULL,";															// Inserta NULL
        }
        else{																				// Si no eres un id
            $sql.= "'".$valor."',";											// Inserta el valor
        }
    }
    $sql = substr($sql, 0, -1); // Le quito la ultima coma al SQL	// Le quito la coma
    $sql .= ");";
    echo $sql;																			// Lo saco por pantalla
    $resultado = $conexion->query($sql);						// Proceso el SQL
    header("Location: ?tabla=".$_GET['tabla']);
?>
```
### css
**estilo.css**
```css
html,body{
  width:100%;
  height:100%;
  padding:0px;
  margin:0px;
}
body{
  display:flex;
  font-family:sans-serif;
  overflow:hidden; 
}
nav{
  background:goldenrod;
  padding:20px;
  gap:20px;
  flex:1;
	display:flex;
  flex-direction:column;
  gap:20px;
}
nav a{
  background:white;
  color:goldenrod;
  text-decoration:none;
	padding:10px;
}
main{
  padding:20px;
  flex:4;
  height:100%;
  overflow-y:scroll;
}
table td{
  padding:10px;
}
table{
  border:2px solid goldenrod;
  width:100%;
}
th{
  background:goldenrod;
  color:white;
  padding:10px;
}





```
### inc
**conexion_bd.php**
```php
<?php
    $host = "localhost";
    $user = "Ureserva_pistas";
    $pass = "Ureserva_pistas2$";
    $db   = "reserva_pistas";

    $conexion = new mysqli($host, $user, $pass, $db);
?>

```
## front
**index.php**
```php
<!--Log in-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    <main>
        <h2>Iniciar sesión</h2>
        <form action="controladores/procesar_login.php" method="POST">
            <input type="text" id="email" name="email" placeholder="Email:" required ><br><br>
            <input type="password" id="password" name="password" placeholder="Contraseña:" required><br><br>
            <input type="submit" value="Iniciar sesión">
        </form>
        <a href="registro.php">Registrarse</a>
    </main>
</body>
<style>
    main{
        background: lightgray;
        justify-content: center;
        padding:20px;
        border-radius:10px;
        margin:auto;
        width: 300px;
        text-align: center;
        height: 350px;
    }
    a{
        text-decoration: none;
        color: red;
    }
</style>
</html>


```
**menu.php**
```php
<?php

include("inc/header.php");



include("inc/footer.php");
?>
```
**registro.php**
```php
<!--Registro-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <main>
        <h2>Registrarse</h2>
        <form action="controladores/procesar_registro.php" method="POST">
            <input type="text" id="email" name="email" placeholder="Email:" required ><br><br>
            <input type="password" id="password" name="password" minlength="6" placeholder="Contraseña:" required><br><br>
            <input type="submit" value="Registrarse">
        </form>
    </main>
</body>
<style>
    main{
        background: lightgray;
        justify-content: center;
        padding:20px;
        border-radius:10px;
        margin:auto;
        width: 300px;
        text-align: center;
        height: 350px;
    }
</style>
</html>


```
### controladores
**procesar_login.php**
```php
<?php
include '../inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Verificar si el email existe
$sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("Este email no está registrado");
}

// Comprobar contraseña
$sql = "SELECT password FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$stored_password = $stmt->get_result()->fetch_assoc()['password'];

if ($password !== $stored_password) {
    die("Contraseña incorrecta");
}

// Login correcto
header("Location: ../menu.php");
exit;

```
**procesar_registro.php**
```php
<?php
include '../inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email no válido");
}

//Validar contraseña
// Verificar longitud
if (strlen($password) < 8 || strlen($password) > 24) {
    die("La contraseña debe tener entre 8 y 24 caracteres");
}
// Verificar que solo tenga letras y números
if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
    die("La contraseña solo puede contener letras y números, sin caracteres especiales");
}

// Verificar si el email ya existe
$sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare(query: $sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("Este email ya está registrado");
}

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (id, email, password) VALUES (NULL, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

echo "Usuario registrado correctamente";
header("Location: ../index.php");
?>

```
### css
**estilo.css**
```css

```
### inc
**conexion_bd.php**
```php
<?php
    $host = "localhost";
    $user = "Ureserva_pistas";
    $pass = "Ureserva_pistas2$";
    $db   = "reserva_pistas";

    $conexion = new mysqli($host, $user, $pass, $db);
?>

```
**footer.php**
```php
    <main>
    <footer>
        <p>2024 Proyecto Entornos. Todos los derechos reservados</p>
    </footer>
</body>
</html>
```
**header.php**
```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva pistras polideportivos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <h1>Reserva pistas polideportivos</h1>
        <nav>
            <ul>
                <li><a href=".php">Tenis</a></li>
                <li><a href=".php">Padel</a></li>
                <li><a href=".php">Futbol</a></li>
                <li><a href=".php">Baloncesto</a></li>
            </ul>
        </nav>
    </header>
    <main>


<style>
	header{
        text-align:center;
    }    	
    nav ul{
        display:flex;
        width:100%;
        justify-content:center;
        list-style-type:none;
        padding:0px;
        margin:0px;
    }
    nav ul li{
        padding:0px;
        margin:0px;
    }
</style>

```

