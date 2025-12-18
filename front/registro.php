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
            <input type="password" id="contra" name="contra" minlength="6" placeholder="Contraseña:" required><br><br>
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

