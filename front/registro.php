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
            <p class="e">Email invalido</p>
            <input type="password" id="password" name="password" minlength="6" placeholder="Contraseña:" required><br><br>
            <p class="1">La contraseña debe tener entre 8 y 24 caracteres</p>
            <p class="2">La contraseña no puede tener caracteres especiales</p>
            <input type="submit" value="Registrarse">
        </form>
    </main>
</body>
<style>
<style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f6f7f3;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    main {
        background-color: #f0f1e9;
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
if (isset($errore) && $errore) {
    echo "<script>
        document.querySelector('form p.e').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p').style.display = 'none';
    </script>";
}
if (isset($error1) && $error1) {
    echo "<script>
        document.querySelector('form p.1').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.1').style.display = 'none';
    </script>";
}
if (isset($error2) && $error2) {
    echo "<script>
        document.querySelector('form p.2').style.display = 'block';
    </script>";
} else {
    echo "<script>
        document.querySelector('form p.2').style.display = 'none';
    </script>";
}
?>
</html>

