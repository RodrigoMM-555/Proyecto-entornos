<?php
$error = false;
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
    include '../index.php';
    exit;
}

// Comprobar contraseña
$sql = "SELECT password FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$stored_password = $stmt->get_result()->fetch_assoc()['password'];

if ($password !== $stored_password) {
    $error = true;
    include '../index.php';
    exit;
}

// Login correcto
header("Location: ../menu.php");
exit;
