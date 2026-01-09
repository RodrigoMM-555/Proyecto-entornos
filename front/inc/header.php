<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva pistas polideportivos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>
        <div>
            <img src="../imagenes/logo.png" alt="logo">
            <h1>Book a court</h1>
        </div>
        <button type="button" onclick="history.back()">&larr; Atrás</button>
        <nav>
            <ul>
                <a href="menu.php?c=<?= $_GET["c"]?>">Polideportivos</a>
                <a href="vista_reservas.php?c=<?= $_GET["c"]?>">Reservas</a>
            </ul>
        </nav>
    </header>
    <main>


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f6f7f3;
    }

    header {
        background: linear-gradient(135deg, #8bc6a8, #b2cdab);
        padding-top: 25px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    header div {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    header div img {
        width: 70px;
        height: 70px;
        margin-right: 15px;
        border-radius: 15px;
    }

    header h1 {
        font-size: 2.2rem;
        color: #2f4f3a;
        letter-spacing: 1px;
    }

    nav ul {
        display: flex;
        justify-content: center;
        list-style: none;
        gap: 30px;
        padding: 15px 0;
        background-color: #f0f1e9;
    }
    header button {
        margin-top: -100px;
        padding: 8px;
        margin-left: 50px;
        text-decoration: none;
        background-color: #f0f1e9;
        font-size: 15px;
        font-weight: 500;
        border: none;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        transition: all 0.3s ease;
    }

    header button:hover {
        background-color: transparent;
        color: white;
    }

        header a {
        align-self: flex-start;
        text-decoration: none;
        color: #2f4f3a;
        padding: 8px 20px;
        border-radius: 20px;
        background-color: #f6f7f3;
        border: 2px solid #c8c9c6ff;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    header a:hover {
        scale: 1.1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
</style>
