<?php
include '../inc/conexion_bd.php?';

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

// Insertar nuevo usuario
$sql = "INSERT INTO usuarios (id, email, password) VALUES (NULL, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

echo "Usuario registrado correctamente";
header("Location: ../index.php");
?>
