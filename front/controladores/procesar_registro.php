<?php
$errore = false;
$error1 = false;
$error2 = false;
include '../inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errore = true;
    include '../registro.php';
    exit;
}

//Validar contraseña
// Verificar longitud
if (strlen($password) < 8 || strlen($password) > 24) {
    $error1 = true;
    include '../registro.php';
    exit;
}
// Verificar que solo tenga letras y números
if (!preg_match('/^[a-zA-Z0-9]+$/', $password)) {
    $error2 = true;
    include '../registro.php';
    exit;
}

// Verificar si el email ya existe
$sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare(query: $sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $errore = true;
    include '../registro.php';
    exit;
}

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (id, email, password) VALUES (NULL, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

echo "Usuario registrado correctamente";
header("Location: ../index.php");
?>
