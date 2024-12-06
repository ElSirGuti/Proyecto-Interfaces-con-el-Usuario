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

// Subir PDF
// Procesar el archivo si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        // Conexión a la base de datos
        $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Obtener datos del archivo
        $nombre = $conexion->real_escape_string($_FILES['archivo']['name']);
        $tipo = $conexion->real_escape_string($_FILES['archivo']['type']);
        $contenido = file_get_contents($_FILES['archivo']['tmp_name']);

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO archivos (nombre, tipo, contenido) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $tipo, $contenido);
        if ($stmt->execute()) {
            $mensaje = "Archivo subido con éxito.";
        } else {
            $mensaje = "Error al subir el archivo: " . $stmt->error;
        }

        $stmt->close();
        $conexion->close();
    } else {
        $mensaje = "Error en la carga del archivo.";
    }
}

// Subir Video
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    try {
        $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión: " . $conexion->connect_error);
        }

        // Procesar el archivo de video
        $nombre = $conexion->real_escape_string($_FILES['video']['name']);
        $tipo = $conexion->real_escape_string($_FILES['video']['type']);
        $contenido = file_get_contents($_FILES['video']['tmp_name']);

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO videos (nombre, tipo, contenido) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
        }

        $stmt->bind_param('sss', $nombre, $tipo, $contenido);

        if ($stmt->execute()) {
            echo "<script>alert('El video se subió correctamente.');</script>";
        } else {
            throw new Exception("Error al subir el video: " . $stmt->error);
        }

        $stmt->close();
        $conexion->close();

    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Subir Subtítulos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['subtitulo'])) {
    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Procesar el archivo de subtítulos
    $nombre = $_FILES['subtitulo']['name'];
    $tipo = $_FILES['subtitulo']['type'];
    $contenido = file_get_contents($_FILES['subtitulo']['tmp_name']);

    // Insertar el subtítulo en la base de datos
    $stmt = $conexion->prepare("INSERT INTO subtitles (nombre, tipo, contenido) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $nombre, $tipo, $contenido);

    if ($stmt->execute()) {
        echo "Subtítulo subido correctamente.";
    } else {
        echo "Error al subir el subtítulo: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}

// Subir imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Procesar múltiples imágenes
    foreach ($_FILES['imagen']['tmp_name'] as $key => $tmp_name) {
        $nombre = $_FILES['imagen']['name'][$key];
        $tipo = $_FILES['imagen']['type'][$key];
        $contenido = file_get_contents($tmp_name);

        $stmt = $conexion->prepare("INSERT INTO imagenes (nombre, tipo, contenido) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $nombre, $tipo, $contenido);

        if ($stmt->execute()) {
            $mensaje = "Imagen subida con éxito.";
        } else {
            $mensaje = "Error al subir la imagen: " . $conexion->error;
        }
        $stmt->close();
        $conexion->close(); // Cerrar la conexión
    }
}

// Obtener imágenes de la base de datos
$imagenes = [];
try {
    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT id, nombre, contenido FROM imagenes ORDER BY id DESC";
    $resultado = $conexion->query($query);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $imagenes[] = $fila;
        }
        $resultado->free();
    }

    $conexion->close();
} catch (Exception $e) {
    echo "<script>alert('Error al cargar las imágenes: " . $e->getMessage() . "');</script>";
}

// Eliminar imagen
if (isset($_GET['eliminar'])) {
    try {
        $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión: " . $conexion->connect_error);
        }

        $id = (int) $_GET['eliminar'];
        $stmt = $conexion->prepare("DELETE FROM imagenes WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "<script>alert('Imagen eliminada con éxito.'); window.location.href = 'uploads.php';</script>";
        } else {
            throw new Exception("Error al eliminar la imagen");
        }

        $stmt->close();
        $conexion->close();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Subir Audio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audio'])) {
    try {
        $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión: " . $conexion->connect_error);
        }

        // Verificar cantidad de audios existentes
        $query = "SELECT COUNT(*) as total FROM audios";
        $resultado = $conexion->query($query);
        $total = $resultado->fetch_assoc()['total'];

        if ($total >= 4) {
            throw new Exception("Solo se permiten 3 archivos de audio. Por favor, elimine uno antes de subir otro.");
        }


        // Procesar el archivo de audio
        $audio_name = $conexion->real_escape_string($_FILES['audio']['name']);
        $audio_data = file_get_contents($_FILES['audio']['tmp_name']);

        $stmt = $conexion->prepare("INSERT INTO audios (audio_name, audio_data, orden) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $audio_name, $audio_data, $orden);

        if ($stmt->execute()) {
            echo "<script>alert('Audio subido correctamente.');</script>";
        } else {
            throw new Exception("Error al subir el audio: " . $stmt->error);
        }

        $stmt->close();
        $conexion->close();

    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Obtener audios
$audios = [];
try {
    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    $query = "SELECT id, audio_name, audio_data, orden FROM audios ORDER BY orden ASC";
    $resultado = $conexion->query($query);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            if (!isset($fila['orden'])) {
                $fila['orden'] = 'No asignado';
            }
            $audios[] = $fila;
        }
        $resultado->free();
    }

    $conexion->close();
} catch (Exception $e) {
    echo "<script>alert('Error al cargar los audios: " . $e->getMessage() . "');</script>";
}

// Eliminar audio
if (isset($_GET['eliminar_audio'])) {
    try {
        $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión: " . $conexion->connect_error);
        }

        $id = (int) $_GET['eliminar_audio'];
        $stmt = $conexion->prepare("DELETE FROM audios WHERE id = ?");
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "<script>alert('Audio eliminado con éxito.'); window.location.href = 'uploads.php';</script>";
        } else {
            throw new Exception("Error al eliminar el audio");
        }

        $stmt->close();
        $conexion->close();
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploads</title>
    <link rel="stylesheet" href="style.css">
    <!-- Estilos de la Página -->
    <style>
        :root {
            --primary: #f9d806;
            --secondary: #130F40;
            --tertiary: #ffee80;
            --cuaternary: #666;
            --background: #fff;
        }

        body {
            background-color: var(--background);
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

        .titulo {
            font-size: 2.5rem;
            margin-left: 230px;
            width: calc(200px + 30%);
            color: var(--secondary);
        }

        .subtitulo {
            font-size: 1.5rem;
            margin-left: 230px;
            width: calc(200px + 30%);
            color: var(--secondary);
        }

        .preview-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin-left: 20px;
            width: 300px;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .preview-box h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .preview-box h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .preview-box h3 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .preview-box p {
            font-size: 12px;
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

        .galeria-imagenes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
            width: 100%;
        }

        .imagen-container {
            position: relative;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .imagen-container:hover {
            transform: translateY(-5px);
        }

        .imagen-preview {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .imagen-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .eliminar-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: background 0.2s;
        }

        .eliminar-btn:hover {
            background: rgba(255, 0, 0, 1);
        }

        .imagen-nombre {
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
            color: var(--secondary);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .audios-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
            width: 100%;
        }

        .audio-item {
            background: #fff;
            margin: 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .audio-item:hover {
            transform: translateY(-5px);
        }

        .audio-item audio {
            width: 100%;
            margin: 10px 0;
        }

        .audio-item p {
            margin: 5px 0;
            color: var(--secondary);
        }
    </style>

    <style>
        .audios-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px 0;
    width: 100%;
}

.audio-item {
    background: #fff;
    margin: 0;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}

.audio-item:hover {
    transform: translateY(-5px);
}

.audio-item audio {
    width: 100%;
    margin: 10px 0;
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
        <h1 class="">Upload Files</h1>
    </div>
    <br><br>

    <!-- Subir Audio -->
    <div class="subtitulo" style="margin-left: 230px;">
        <h2>Subir Audio (Máximo 3)</h2>
    </div>

    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="audio">Selecciona un archivo de audio:</label>
                <input type="file" name="audio" id="audio" accept="audio/*" required>
            </div>
            <div class="form-group">
                <label for="orden">Orden de reproducción (1-3):</label>
                <input type="number" name="orden" id="orden" min="1" max="3" required>
            </div>
            <button class="btn" type="submit">Subir Audio</button>
        </form>

        <div class="audios-container">
            <?php if (empty($audios)): ?>
                <p>No hay audios subidos.</p>
            <?php else: ?>
                <?php foreach ($audios as $audio): ?>
                    <div class="audio-item">
                        <audio controls>
                            <source src="data:audio/mpeg;base64,<?= base64_encode($audio['audio_data']) ?>" type="audio/mpeg">
                            Tu navegador no soporta el elemento de audio.
                        </audio>
                        <p>
                            <?= htmlspecialchars($audio['audio_name']) ?> 
                            <span class="orden-badge">Orden actual: <?= isset($audio['orden']) ? $audio['orden'] : 'No asignado' ?></span>
                        </p>
                        <div class="audio-controls">
                            <select class="orden-select" onchange="cambiarOrden(<?= $audio['id'] ?>, this.value)">
                                <option value="">Cambiar orden</option>
                                <option value="1">Orden 1</option>
                                <option value="2">Orden 2</option>
                                <option value="3">Orden 3</option>
                            </select>
                            <button onclick="eliminarAudio(<?= $audio['id'] ?>)" class="btn">Eliminar</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <style>
            .orden-badge {
                background-color: var(--secondary);
                color: white;
                padding: 3px 8px;
                border-radius: 10px;
                margin-left: 10px;
                font-size: 0.9em;
            }

            .audio-controls {
                display: flex;
                gap: 10px;
                align-items: center;
                margin-top: 10px;
            }

.orden-select {
    padding: 5px;
    border-radius: 4px;
    border: 1px solid var(--cuaternary);
}

.audio-item {
    margin-bottom: 15px;
    padding: 15px;
    border: 1px solid var(--cuaternary);
    border-radius: 5px;
}

.audio-item p {
    margin: 10px 0;
    display: flex;
    align-items: center;
}
</style>

<script>
function cambiarOrden(audioId, nuevoOrden) {
    if (!nuevoOrden) return; // Si no se seleccionó ningún orden

    fetch('cambiar_orden_audio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `audio_id=${audioId}&nuevo_orden=${nuevoOrden}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Recargar la página para mostrar los cambios
        } else {
            alert(data.message || 'Error al cambiar el orden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cambiar el orden');
    });
}
</script>
    </div>

    <!-- Subir PDF -->
    <div class="subtitulo" style="margin-left: 230px;">
        <h2>Subir Archivo PDF</h2>
    </div>

    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">

        <!-- Formulario -->
        <form action="" method="post" enctype="multipart/form-data">
            <label for="archivo">Selecciona un archivo PDF:</label>
            <input type="file" name="archivo" id="archivo" accept="application/pdf" required>
            <button class="btn" type="submit">Subir</button>
        </form>
    </div>
    <br>

    <!-- Subir Video -->
    <div class="subtitulo" style="margin-left: 230px;">
        <h2>Subir Video</h2>
    </div>

    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="video">Selecciona un video:</label>
            <input type="file" name="video" id="video" accept="video/*" required>
            <button class="btn" type="submit">Subir Video</button>
        </form>
    </div>
    <br>

    <!-- Subir Subtítulos -->
    <div class="subtitulo" style="margin-left: 230px;">
        <h2>Subir Subtítulos (VTT)</h2>
    </div>

    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <form id="subtituloForm" method="post" enctype="multipart/form-data">
            <label for="subtitulo">Selecciona un archivo VTT:</label>
            <input type="file" name="subtitulo" id="subtitulo" accept=".vtt" required>
            <button class="btn" type="submit">Subir Subtítulos</button>
        </form>
    </div>
    <br>

    <!-- Subir Imagen -->
    <div class="subtitulo" style="margin-left: 230px;">
        <h2>Subir Imágenes</h2>
        <?php if (isset($mensaje)): ?>
            <p><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
    </div>
    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="imagen[]" accept="image/*" multiple required>
            <button class="btn" type="submit">Subir Imágenes</button>
        </form>
        <br>

        <h2>Imágenes Subidas</h2>
        <?php if (isset($mensaje)): ?>
            <p><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <div class="galeria-imagenes">
            <?php if (empty($imagenes)): ?>
                <p>No hay imágenes subidas.</p>
            <?php else: ?>
                <?php foreach ($imagenes as $imagen): ?>
                    <div class="imagen-container">
                        <div class="imagen-preview">
                            <img src="data:image/jpeg;base64,<?= base64_encode($imagen['contenido']) ?>"
                                alt="<?= htmlspecialchars($imagen['nombre']) ?>">
                            <button class="eliminar-btn" onclick="eliminarImagen(<?= $imagen['id'] ?>)">×</button>
                        </div>
                        <p class="imagen-nombre"><?= htmlspecialchars($imagen['nombre']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>



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

    <script>
        function eliminarImagen(id) {
            if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
                window.location.href = `?eliminar=${id}`;
            }
        }

        function eliminarAudio(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este audio?')) {
                window.location.href = `?eliminar_audio=${id}`;
            }
        }
    </script>
</body>

</html>