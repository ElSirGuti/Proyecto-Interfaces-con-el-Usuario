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

// Obtener el archivo más reciente de la base de datos
$archivoPDF = null;

$conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el último archivo de la tabla
$resultado = $conexion->query("SELECT nombre, tipo, contenido FROM archivos ORDER BY id DESC LIMIT 1");
if ($resultado->num_rows > 0) {
    $archivo = $resultado->fetch_assoc();
    // Guardar temporalmente el contenido para incrustarlo
    $archivoPDF = "data:" . $archivo['tipo'] . ";base64," . base64_encode($archivo['contenido']);
} else {
    $mensaje = "No hay archivos disponibles.";
}

$conexion->close();
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
            --background: #fff;
        }

        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        label {
            font-size: medium;
            color: var(--secondary);
        }

        input {
            background-color: var(--cuaternary);
        }

        textarea {
            background-color: var(--cuaternary);
        }

        select {
            background-color: var(--cuaternary);
        }

        .titulo {
            font-size: 2.5rem;
            margin-left: 230px;
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
            border-bottom: 1px solid var(--primary);
        }

        .sidebar ul li a {
            font-size: 1.5rem;
            color: var(--cuaternary);
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            color: var(--primary);
        }

        .sidebar .logout {
            font-size: 1.5rem;
            position: absolute;
            bottom: 20px;
            left: 20px;
        }

        .sidebar .logout a {
            color: var(--cuaternary);
            text-decoration: none;
        }

        .sidebar .logout a:hover {
            color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul>
            <li><a href="dashboard.php">Personalization</a></li>
            <li><a href="editar_perfil.php">Edit Profile</a></li>
            <li><a href="uploads.php">Uploads</a></li>
            <li><a href="manual.php">User Manual</a></li>
        </ul>
        <div class="logout">
            <a href="php/cerrar_sesion.php">Log Out</a>
        </div>
    </div>

    <div class="titulo" style="">
        <h1>User Manual</h1>
    </div>

    <!-- Visualizador del PDF -->
    <section>
        <?php if ($archivoPDF): ?>
            <!-- Contenedor para centrar -->
            <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100vh;">
                <embed src="<?= $archivoPDF ?>" width="900" height="700"></embed>
            </div>
        <?php else: ?>
            <!-- Mensaje si no hay archivos -->
            <div
                style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f4f4f4;">
                <p>No hay archivos disponibles.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Script to update colors on all pages -->
    <script>
        // Función para actualizar los colores desde localStorage
        function updateColorsOnAllPages() {
            const root = document.documentElement;
            const primaryColor = localStorage.getItem('primaryColor');
            const secondaryColor = localStorage.getItem('secondaryColor');
            const tertiaryColor = localStorage.getItem('tertiaryColor');
            const cuaternaryColor = localStorage.getItem('cuaternaryColor');
            const backgroundColor = localStorage.getItem('backgroundColor');

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

            if (backgroundColor) {
                root.style.setProperty('--background', backgroundColor);
                document.body.style.backgroundColor = backgroundColor;
            }
        }

        // Cargar los colores cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', updateColorsOnAllPages);

        // También actualizar los colores inmediatamente
        updateColorsOnAllPages();
    </script>

    <!-- Script to handle font changes -->
    <script src="font-changer.js"></script>

    <!-- Script to apply font sizes -->
    <script src="font-sizes.js"></script>
</body>