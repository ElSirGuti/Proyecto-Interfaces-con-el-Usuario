<?php
session_start();

if (isset($_SESSION['usuario'])) {
    if (isset($_SESSION['nombre_completo'])) {
        $nombre_completo = $_SESSION['nombre_completo'];
    } else {
        $nombre_completo = '';
    }

    if (isset($_SESSION['correo'])) {
        $correo = $_SESSION['correo'];
    } else {
        $correo = '';
    }
} else {
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

    <div class="formulario" style="margin-left: 230px">
        <form>
            <div>
                <label for="gender">Género:</label>
                <select id="gender" name="gender">
                    <option value="male">Hombre</option>
                    <option value="female">Mujer</option>
                </select>
            </div>

            <div>
                <label for="title">Título:</label>
                <select id="title" name="title">
                    <option value="mr">Sr.</option>
                    <option value="mrs">Sra.</option>
                </select>
            </div>

            <div>
                <label for="name">Nombre completo:</label>
                <input type="text" id="name" name="nombre_completo" value="<?php echo $nombre_completo; ?>" disabled>
            </div>

            <div>
                <label for="location">Ubicación:</label>
                <div id="map" style="width: 60%; height: 400px;"></div>
                <input type="hidden" id="city" name="city">
                <input type="hidden" id="state" name="state">
                <input type="hidden" id="country" name="country">
                <input type="hidden" id="postcode" name="postcode">
            </div>

            <div>
                <label for="coordinates">Coordenadas:</label>
                <input type="text" id="latitude" name="latitude">
                <input type="text" id="longitude" name="longitude">
            </div>

            <div>
                <label for="timezone">Zona horaria:</label>
                <input type="text" id="offset" name="offset">
                <input type="text" id="description" name="description">
            </div>

            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="correo" value="<?php echo $correo; ?>" disabled>
            </div>

            <div>
                <label for="dob">Fecha de nacimiento:</label>
                <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>">
                <input type="text" id="age" name="age" placeholder="Edad" disabled>
            </div>

            <div>
                <label for="identifier">Identificador:</label>
                <input type="text" id="identifier" name="identifier" placeholder="0424, 0412, etc.">
            </div>

            <div>
                <label for="phone">Teléfono móvil:</label>
                <input type="text" id="phone" name="phone">
            </div>

            <div>
                <label for="house_phone">Teléfono de casa:</label>
                <input type="text" id="house_phone" name="house_phone">
            </div>

            <div>
                <label for="picture">Foto:</label>
                <input type="file" id="picture" name="picture">
            </div>

            <div>
                <label for="nationality">Nacionalidad:</label>
                <select id="nationality" name="nationality">
                </select>
            </div>
        </form>
    </div>



    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="mapa.js"></script>
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