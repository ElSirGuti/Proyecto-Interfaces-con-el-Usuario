<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
            <script>
                alert("Debes iniciar sesión para acceder a esta página");
                window.location = "login.php";
            </script>
        ';
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">

    <style>
        :root {
            --primary: #f9d806;
            --secondary: #130F40;
            --tertiary: #ffee80;
            --cuaternary: #666;
        }

        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        label {
            font-size: medium;
        }

        .titulo {
            font-size: 2.5rem;
            margin: auto;
            width: calc(200px + 30%);
            color: var(--secondary);
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: var(--secondary);
            color: #fff;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 10px;
            border-bottom: 1px solid #444;
        }

        .sidebar ul li a {
            font-size: 1.5rem;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            color: #ccc;
        }

        .sidebar .logout {
            font-size: 1.5rem;
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .sidebar .logout a {
            color: #fff;
            text-decoration: none;
        }

        .sidebar .logout a:hover {
            color: #ccc;
        }
    </style>
</head>

<body>
    <div class="titulo" style="">
        <h1 class="">Edit Profile</h1>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="dashboard.php">Personalization</a></li>
            <li><a href="editar_perfil.php">Edit Profile</a></li>
        </ul>
        <div class="logout">
            <a href="php/cerrar_sesion.php">Log Out</a>
        </div>
    </div>





    <!-- Script to update colors on all pages -->
    <script>
        function updateColorsOnAllPages() {
            const root = document.documentElement;
            const primaryColor = localStorage.getItem('primaryColor');
            const secondaryColor = localStorage.getItem('secondaryColor');
            const tertiaryColor = localStorage.getItem('tertiaryColor');
            const cuaternaryColor = localStorage.getItem('cuaternaryColor');

            if (primaryColor) {
                root.style.setProperty('--primary', primaryColor);
            }

            if (secondaryColor) {
                root.style.setProperty('--secondary', secondaryColor);
            }

            if (tertiaryColor) {
                root.style.setProperty('--tertiary', tertiaryColor);
            }

            if (cuaternaryColor) {
                root.style.setProperty('--cuaternary', cuaternaryColor);
            }
        }

        updateColorsOnAllPages();
    </script>
</body>

</html>