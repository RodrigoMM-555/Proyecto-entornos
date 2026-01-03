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

if ($password !== $stored_password) {
    header("Location: ../index.php?error=invalid");
    exit;
}

// Login correcto
header("Location: ../menu.php?c=$email");
exit;
