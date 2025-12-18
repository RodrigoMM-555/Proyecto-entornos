<?php
include 'inc/conexion_bd.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email no válido");
}

// Validar contraseña (mínimo 6 caracteres)
if (strlen($password) < 6) {
    die("La contraseña debe tener al menos 6 caracteres");
}

// Verificar si el email ya existe
$sql = "SELECT contraseña FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':email' => $email]);

// Guardar resultado para poder usar num_rows
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Este email ya está registrado");
}

// Dar acceso al usuario


echo "Usuario registrado correctamente";
