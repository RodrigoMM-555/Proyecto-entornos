# Reporte de proyecto

## Estructura del proyecto

```
/home/RodrigoMenendez/Documents/GitHub/Proyecto-entornos
├── BBDD
│   ├── base de datos.sql
│   └── usuarui.sql
├── Captura desde 2025-12-19 13-24-14.png
├── Captura desde 2025-12-19 13-25-15.png
├── Registro.md
├── back
│   ├── controladores
│   │   ├── insertar.php
│   │   ├── leer.php
│   │   ├── poblar_menu.php
│   │   ├── procesaeliminar.php
│   │   └── procesainsertar.php
│   ├── css
│   │   └── estilo.css
│   ├── inc
│   │   └── conexion_bd.php
│   └── index.php
├── cosas.md
├── front
│   ├── controladores
│   │   ├── procesa_eliminar_reserva.php
│   │   ├── procesa_reserva.php
│   │   ├── procesar_login.php
│   │   └── procesar_registro.php
│   ├── inc
│   │   ├── conexion_bd.php
│   │   ├── footer.php
│   │   └── header.php
│   ├── index.php
│   ├── menu.php
│   ├── polideportivos.php
│   ├── registro.php
│   ├── reserva.php
│   └── vista_reservas.php
└── imagenes
    └── logo.png
```

## Código (intercalado)

# Proyecto-entornos
**Registro.md**
```markdown
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


```
**cosas.md**
```markdown

5. Barra de navegacion para buscar el polideportivo en la pagina de menu

9. Terminar el CRUD del back, falta actualizar, ya se puede leer, añadir y eliminar

10. Sustituir la pagina de inicio de sesion por una de bienvenida que redirija a la de inicio de sesion o registro. 

11. Pagina de perfil

12. Mostrar que horas ya estan pilladas
```
## BBDD
**base de datos.sql**
```sql
-- BASE DE DATOS 2.0 CON CASCADE Y RESTRICT---------------------------------------------------------------------------------------------------

CREATE DATABASE reserva_pistas;
USE reserva_pistas;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabla de polideportivos
CREATE TABLE polideportivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    imagen VARCHAR(250)
);

-- Tabla de pistas
CREATE TABLE pistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    polideportivo_id INT,
    max_personas INT CHECK (max_personas BETWEEN 1 AND 30),
    precio DECIMAL(10,2),
    imagen VARCHAR(250),
    deporte VARCHAR(50) NOT NULL,
    caracteristicas TEXT,
    FOREIGN KEY (polideportivo_id) REFERENCES polideportivos(id) 
        ON DELETE CASCADE  -- Elimina las pistas si se elimina un polideportivo
);

-- Tabla de reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    pista_id INT,
    fecha_hora DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE,  -- Elimina las reservas si se elimina un usuario
    FOREIGN KEY (pista_id) REFERENCES pistas(id)
        ON DELETE RESTRICT  -- No permite eliminar pistas si hay reservas asociadas
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
        <input type="submit" value="Insertar">
    </div>
</form>

<link rel="stylesheet" href="css/estilo.css">







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
        echo "<th>Eliminar</th>";
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
        echo '<td><a class="eliminar" href="controladores/procesaeliminar.php?tabla='.$_GET['tabla'].'&id='.$fila['id'].'">❌</a></td>';  
        echo "</tr>";
        }
    ?>
</table>
<p>|</p>

<style>
    p{
        color: #f6f7f3;
    }
</style>

<a href="?operacion=insertar&tabla=<?= $_GET['tabla'] ?>" class="boton_insertar">+</a>


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
**procesaeliminar.php**
```php
<?php

include "../inc/conexion_bd.php";

$sql = "DELETE FROM ".$_GET['tabla']." WHERE id=".$_GET['id'];
$conexion->query($sql);

header("Location: ../?tabla=".$_GET['tabla']);
exit;

?>

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

/* Reset y base */
html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f6f7f3;
}

body {
    display: flex;
    overflow: hidden;
}

/* Navegación lateral */
nav {
    background-color: #8bc6a8;
    padding: 25px 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    min-width: 200px;
    box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    height: 100vh;
    overflow-y: auto;
}

nav a {
    background-color: #f0f1e9;
    color: #2f4f3a;
    text-decoration: none;
    padding: 12px 15px;
    border-radius: 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    text-align: center;
}

nav a:hover {
    background-color: #6aa98b;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

/* Área principal */
main {
    flex: 4;
    padding: 25px;
    height: 100%;
    overflow-y: auto;
}

/* Tabla */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
    background-color: #f0f1e9;
}

td a.eliminar {
    text-decoration: none;
}

th, td {
    padding: 12px 18px;
    text-align: left;
    color: #2f4f3a;
}

th {
    background-color: #6aa98b;
    color: white;
    font-weight: 600;
}

tr:nth-child(even) {
    background-color: #e3eddc;
}

tr:hover {
    background-color: #d9e6dc;
}

/* Botón de insertar */
.boton_insertar {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #8bc6a8;
    color: white;
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50%;
    text-align: center;
    font-size: 1.8rem;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.boton_insertar:hover {
    background-color: #6aa98b;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.25);
}

/* Formulario general */
form {
    max-width: 95%;
    display: flex;
    flex-direction: column;
    gap: 20px;
    background-color: #f0f1e9;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}

/* Controles del formulario */
.control_formulario {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

label {
    font-weight: 500;
    color: #2f4f3a;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="number"] {
    padding: 10px 12px;
    border: 2px solid #8bc6a8;
    border-radius: 12px;
    outline: none;
    font-size: 1rem;
    transition: all 0.3s ease;
}

input:focus {
    border-color: #6aa98b;
    box-shadow: 0 0 0 3px rgba(139,198,168,0.3);
}

/* Botón enviar */
input[type="submit"] {
    font-size: medium;
    padding: 12px 25px;
    background-color: #8bc6a8;
    color: white;
    font-weight: 600;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #6aa98b;
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(0,0,0,0.2);
}

/* Responsive */
@media (max-width: 800px) {
    body {
        flex-direction: column;
    }
    nav {
        flex-direction: row;
        overflow-x: auto;
        width: 100%;
        height: auto;
    }
    main {
        flex: none;
        height: auto;
        padding: 20px;
    }
    table {
        font-size: 0.9rem;
    }
}

@media (max-width: 600px) {
    .control_formulario {
        flex-direction: column;
    }
    input[type="submit"] {
        width: 100%;
    }
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
            <p>Email o contraseña incorrectos</p>
            <input type="submit" value="Iniciar sesión">
        </form>
        <a href="registro.php">Registrarse</a>
    </main>
</body>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(#8bc6a8, #b2cdab);;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    main {
        background-color: #f6f7f3;
        padding: 35px 30px;
        width: 320px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    main h2 {
        margin-bottom: 25px;
        color: #2f4f3a;
        font-size: 1.8rem;
    }

    form input[type="text"],
    form input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 1px solid #b2cdab;
        font-size: 1rem;
        outline: none;
        transition: border 0.3s, box-shadow 0.3s;
    }

    form input[type="text"]:focus,
    form input[type="password"]:focus {
        border-color: #8bc6a8;
        box-shadow: 0 0 0 2px rgba(139, 198, 168, 0.4);
    }

    form input[type="submit"] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 20px;
        background-color: #8bc6a8;
        color: white;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
    }

    form input[type="submit"]:hover {
        background-color: #6aa98b;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    form p {
        display: none;
        color: red;
        font-weight: 500;
        margin-top: 0px;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #2f4f3a;
        font-weight: 500;
        transition: color 0.3s;
    }

    a:hover {
        color: #6aa98b;
        text-decoration: underline;
    }
</style>
<?php
if (isset($_GET["error"]) && $_GET["error"] == "invalid") {
    echo "<script>
        document.querySelector('form p').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p').style.display = 'none';
    </script>";
}
?>

</html>


```
**menu.php**
```php
<?php
include("inc/conexion_bd.php");
include("inc/header.php");

session_start();

    $sql = "SELECT * FROM polideportivos;";

    $resultado = $conexion->query($sql);
    while ($fila = $resultado->fetch_assoc()) {
?>
    <article>
        <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
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
```
**polideportivos.php**
```php
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
        <div>
            <img src="<?= $fila['imagen'] ?>" alt="Placeholder">
            <h3>Pista de <?= $fila['deporte'] ?></h3>
            <p>Precio: <?= $fila['precio'] ?>€/hora</p>

            <form action="reserva.php" method="POST">
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
            <p><?= $fila['max_personas'] ?> personas - <?= $fila['caracteristicas'] ?></p>
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
        padding: 8px 8px;
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
            <p class="email_invalid">Email invalido</p>
            <p class="password_length">La contraseña debe tener entre 8 y 24 caracteres</p>
            <p class="password_special">La contraseña no puede tener caracteres especiales</p>
            <p class="password_format">La contraseña debe contener al menos una letra y un número</p>
            <p class="email_exists">Este correo ya esta registrado</p>
            <input type="submit" value="Registrarse">
        </form>
    </main>
</body>

<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(#8bc6a8, #b2cdab);;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    main {
        background-color: #f6f7f3;
        padding: 35px 30px;
        width: 320px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    main h2 {
        margin-bottom: 25px;
        color: #2f4f3a;
        font-size: 1.8rem;
    }

    form input[type="text"],
    form input[type="password"] {
        width: 80%;
        padding: 12px 15px;
        margin-bottom: 18px;
        border-radius: 10px;
        border: 1px solid #b2cdab;
        font-size: 1rem;
        outline: none;
        transition: border 0.3s, box-shadow 0.3s;
    }

    form input[type="text"]:focus,
    form input[type="password"]:focus {
        border-color: #8bc6a8;
        box-shadow: 0 0 0 2px rgba(139, 198, 168, 0.4);
    }

    form input[type="submit"] {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 20px;
        background-color: #8bc6a8;
        color: white;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s, box-shadow 0.2s;
    }

    form input[type="submit"]:hover {
        background-color: #6aa98b;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    form p {
        display: none;
        color: red;
        font-weight: 500;
        margin-top: 0px;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #2f4f3a;
        font-weight: 500;
        transition: color 0.3s;
    }

    a:hover {
        color: #6aa98b;
        text-decoration: underline;
    }
</style>
<?php
if (isset($_GET["error"]) && $_GET["error"] == "email_invalid") {
    echo "<script>
        document.querySelector('form p.email_invalid').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.email_invalid').style.display = 'none';
    </script>";
}
if (isset($_GET["error"]) && $_GET["error"] == "email_exists") {
    echo "<script>
        document.querySelector('form p.email_exists').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.email_exists').style.display = 'none';
    </script>";
}
if (isset($_GET["error"]) && $_GET["error"] == "password_length") {
    echo "<script>
        document.querySelector('form p.password_length').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.password_length').style.display = 'none';
    </script>";
}
if (isset($_GET["error"]) && $_GET["error"] == "password_special") {
    echo "<script>
        document.querySelector('form p.password_special').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.password_special').style.display = 'none';
    </script>";
}
if (isset($_GET["error"]) && $_GET["error"] == "password_format") {
    echo "<script>
        document.querySelector('form p.password_format').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.password_format').style.display = 'none';
    </script>";
}
?>
</html>


```
**reserva.php**
```php
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
```
**vista_reservas.php**
```php
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
```
### controladores
**procesa_eliminar_reserva.php**
```php

<?php

include "../inc/conexion_bd.php";

$sql = "DELETE FROM reservas WHERE id=".$_GET['reserva_id'];
$conexion->query($sql);
header("Location: ../vista_reservas.php");

?>

```
**procesa_reserva.php**
```php
<?php
include("../inc/conexion_bd.php");

session_start();

$pista_id = $_POST['pista_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$fecha_hora = $fecha . ' ' . $hora . ":00";

// Verificar si ya existe una reserva
$stmt = $conexion->prepare("SELECT id FROM reservas WHERE pista_id = ? AND fecha_hora = ? LIMIT 1");
$stmt->bind_param("is", $pista_id, $fecha_hora);
$stmt->execute();
$stmt->store_result();

//Confirma o no la reserva
$confirmacion = 'exito';
if ($stmt->num_rows > 0) {
    $confirmacion = 'error';

//En caso de confirmar
} else {
    // Obtener usuario
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION["usuario"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    $usuario_id = $fila['id'];

    // Insertar reserva
    $sql = "INSERT INTO reservas VALUES (NULL, $usuario_id, $pista_id, '$fecha_hora')";
    $conexion->query($sql);
}

// Formulario autoenviado
echo '
<form id="autoForm" action="../reserva.php?confirmacion='.$confirmacion.'" method="POST">
    <input type="hidden" name="pista_id" value="'.$pista_id.'">
    <input type="hidden" name="fecha" value="'.$fecha.'">
    <input type="hidden" name="hora" value="'.$hora.'">
</form>
<script>
    document.getElementById("autoForm").submit();
</script>';
exit;
?>

```
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
    $error = true;
    header("Location: ../index.php?error=invalid");
    exit;
}

// Comprobar contraseña
$sql = "SELECT password FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stored_password = $stmt->get_result()->fetch_assoc()['password'];

//Codificar la contraseña que entra para comparar con la almacenada
$password_codifica = password_hash($password, PASSWORD_BCRYPT);


// Verificar si la contraseña es correcta
if (!password_verify($password, $stored_password)) {
    header("Location: ../index.php?error=invalid");
    exit;
} else {
    // Iniciar sesión
    session_start();
    $_SESSION["usuario"] = $email;
    header("Location: ../menu.php");
    exit;
}
```
**procesar_registro.php**
```php
<?php
include '../inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../registro.php?error=email_invalid");
    exit;
}

//Validar contraseña
// Verificar longitud
if (strlen($password) < 8 || strlen($password) > 24) {
    header("Location: ../registro.php?error=password_length");
    exit;
}
// Verificar que solo tenga letras y números
if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
    header("Location: ../registro.php?error=password_special");
    exit;
}
//Verficar que tenga al menos una letra y un numero
if (!preg_match('/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+$/', $password)) {
    header("Location: ../registro.php?error=password_format");
    exit;
}

// Verificar si el email ya existe
$sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare(query: $sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    header("Location: ../registro.php?error=email_exists");
    exit;
}

//Codificar la contraseña
$password_codifica = password_hash($password, PASSWORD_BCRYPT);

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (id, email, password) VALUES (NULL, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $email, $password_codifica);
$stmt->execute();

echo "Usuario registrado correctamente";
header("Location: ../index.php");
?>

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
    </main>
    <footer>
        <p>2025 Proyecto Entornos | Rodrigo Menéndez Molina · Pau Contreras Romero</p>
    </footer>
</body>
</html>

<style>
    footer {
        background: linear-gradient(135deg, #8bc6a8, #b2cdab);
        padding: 15px 0;
        text-align: center;
        margin-top: 40px;
        box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
    }

    footer p {
        color: #2f4f3a;
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
</style>
```
**header.php**
```php
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva pistas polideportivos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <div>
            <img src="../imagenes/logo.png" alt="logo">
            <h1>Book a court</h1>
        </div>
        <button type="button" onclick="history.back()">&larr; Atrás</button>
    </header>
    <nav>
        <ul>
            <a href="menu.php">Polideportivos</a>
            <a href="vista_reservas.php">Reservas</a>
        </ul>
    </nav>
    <main>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f6f7f3;
    }

    header {
        background: linear-gradient(135deg, #8bc6a8, #b2cdab);
        padding-top: 25px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    header div {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    header div img {
        width: 70px;
        height: 70px;
        margin-right: 15px;
        border-radius: 15px;
    }

    header h1 {
        font-size: 2.2rem;
        color: #2f4f3a;
        letter-spacing: 1px;
    }

    nav ul {
        display: flex;
        justify-content: center;
        list-style: none;
        gap: 30px;
        padding: 15px 0;
        background-color: #f0f1e9;
    }
    
    header button {
        margin-top: -100px;
        padding: 8px;
        margin-left: 50px;
        text-decoration: none;
        background-color: #f0f1e9;
        font-size: 15px;
        font-weight: 500;
        border: none;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        transition: all 0.3s ease;
    }

    header button:hover {
        background-color: transparent;
        color: white;
    }

    a {
        align-self: flex-start;
        text-decoration: none;
        color: #2f4f3a;
        padding: 8px 20px;
        border-radius: 20px;
        background-color: #f6f7f3;
        border: 2px solid #c8c9c6ff;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    a:hover {
        scale: 1.1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
</style>

```
## imagenes