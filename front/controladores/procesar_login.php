<?php
include '../inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Verificar si el email ya existe
$sql = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':email' => $email]);

$stmt->store_result();

if ($stmt->num_rows < 0) {
    die("Este email no está registrado");
}

// Comprobar contraseña
$sql = "SELECT password FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':email' => $email]);

// Dar acceso al usuario
$stmt->bind_result($stored_password);
$stmt->fetch();

if ($password === $stored_password) {
    echo "Acceso concedido";
} else {
    die("Contraseña incorrecta");
}

echo "Usuario registrado correctamente";
