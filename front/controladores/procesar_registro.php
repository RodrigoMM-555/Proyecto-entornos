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
$sql = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->execute([':email' => $email]);

// Guardar resultado para poder usar num_rows
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Este email ya está registrado");
}

// Insertar usuario
$sql = "INSERT INTO usuarios VALUES (NULL, :email, :password)";
$stmt = $conexion->prepare($sql);
$stmt->execute([
    ':email' => $email,
    ':password' => $password
]);

echo "Usuario registrado correctamente";
header("Location: ../index.php");
?>
