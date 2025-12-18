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
            <input type="password" id="contra" name="contra" placeholder="Contraseña:" required><br><br>
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

