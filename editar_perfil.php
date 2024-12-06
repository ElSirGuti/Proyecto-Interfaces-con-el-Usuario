<?php
session_start();
include 'php/conexion_be.php'; // Asegúrate de que este archivo existe y tiene la conexión a la BD

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    // Consulta para obtener los datos del usuario
    $query = "SELECT nombre_completo, correo, usuario FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datos = mysqli_fetch_assoc($resultado);
        $nombre_completo = $datos['nombre_completo'];
        $correo = $datos['correo'];
        $nombre_usuario = $datos['usuario'];
    } else {
        $nombre_completo = '';
        $correo = '';
        $nombre_usuario = '';
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
    <div class="titulo" style="">
        <h1 class="">Edit Profile</h1>
    </div>

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

    <br>
    <div class="formulario" style="margin-left: 230px">
        <form action="guardar_datos.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="gender">Género:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Hombre</option>
                    <option value="female">Mujer</option>
                </select>
            </div>

            <div>
                <label for="title">Título:</label>
                <select id="title" name="title" required>
                    <option value="mr">Sr.</option>
                    <option value="mrs">Sra.</option>
                </select>
            </div>

            <div>
                <label for="name">Nombre completo:</label>
                <input type="text" id="name" name="nombre_completo" value="" required>
            </div>

            <div>
                <label for="username">Nombre de usuario:</label>
                <input type="text" id="username" name="username" value="" required>
            </div>

            <div>
                <label for="location">Ubicación:</label>
                <div id="map" style="width: 60%; height: 400px;"></div>

                <div class="location-fields">
                    <div class="field-group">
                        <label for="city">Ciudad:</label>
                        <input type="text" id="city" name="city" required>
                    </div>

                    <div class="field-group">
                        <label for="state">Estado/Provincia:</label>
                        <input type="text" id="state" name="state" required>
                    </div>

                    <div class="field-group">
                        <label for="country">País:</label>
                        <input type="text" id="country" name="country" required>
                    </div>

                    <div class="field-group">
                        <label for="postcode">Código Postal:</label>
                        <input type="text" id="postcode" name="postcode" required>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <label>Coordenadas:</label>
                <div class="coordinates-group">
                    <div class="field-group">
                        <label for="latitude">Latitud:</label>
                        <input type="text" id="latitude" name="latitude" required>
                    </div>
                    <div class="field-group">
                        <label for="longitude">Longitud:</label>
                        <input type="text" id="longitude" name="longitude" required>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <label for="street">Dirección:</label>
                <textarea id="description" name="description" cols="50" rows="4" required></textarea>
            </div>
            <br>
            <div>
                <label>Huso Horario:</label>
                <div class="timezone-group">
                    <div class="field-group">
                        <label for="timezone">Diferencia horaria (UTC):</label>
                        <input type="text" id="timezone" name="timezone" value="UTC-04:00" required>
                    </div>
                    <div class="field-group">
                        <label for="offset">Zona horaria:</label>
                        <input type="text" id="offset" name="offset" required>
                    </div>
                </div>
            </div>


            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="correo" value="" required>
            </div>

            <div>
                <label for="dob">Fecha de nacimiento:</label>
                <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required>
                <input type="text" id="age" name="age" placeholder="Edad" required>
            </div>

            <script>
                // Agregar el evento para calcular la edad
                document.getElementById('dob').addEventListener('change', function () {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }

                    document.getElementById('age').value = age;
                });

                // Establecer la fecha máxima como la fecha actual
                document.getElementById('dob').max = new Date().toISOString().split('T')[0];

                // Eventos específicos para el date picker
                const dobInput = document.getElementById('dob');

                // Click en el campo de fecha
                dobInput.addEventListener('click', function () {
                    if (this.id in metrics) {
                        metrics[this.id].b++;
                        metrics[this.id].m++;
                        updateTable();
                    }
                });

                // Cuando se abre el date picker
                dobInput.addEventListener('focus', function () {
                    lastFocusedInput = this.id;
                });

                // Cuando se selecciona una fecha
                dobInput.addEventListener('change', function () {
                    if (this.id in metrics) {
                        metrics[this.id].b++;
                        metrics[this.id].m++;
                        updateTable();
                    }
                });

                // Cuando se usa el teclado en el date picker
                dobInput.addEventListener('keydown', function (e) {
                    if (this.id in metrics) {
                        if (lastInteractionType === 'mouse') {
                            metrics[this.id].h++;
                            lastInteractionType = 'keyboard';
                        }
                        if (e.key !== 'Tab' && e.key !== 'Shift') {
                            metrics[this.id].k++;
                        }
                        updateTable();
                    }
                });
            </script>

            <script>
                // Agregar el evento para calcular la edad
                document.getElementById('dob').addEventListener('change', function () {
                    const dob = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const monthDiff = today.getMonth() - dob.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }

                    document.getElementById('age').value = age;
                });

                // Establecer la fecha máxima como la fecha actual
                document.getElementById('dob').max = new Date().toISOString().split('T')[0];
            </script>

            <div>
                <label for="identifier">Identificador:</label>
                <input type="text" id="identifier" name="identifier" placeholder="0424, 0412, etc." required>
            </div>

            <div>
                <label for="phone">Teléfono móvil:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div>
                <label for="house_phone">Teléfono de casa:</label>
                <input type="text" id="house_phone" name="house_phone" required>
            </div>

            <div>
                <label for="picture">Foto:</label>
                <input type="file" id="picture" name="picture" accept="image/*" required>
                <div id="imageContainer"></div>
            </div>

            <style>
                #imageContainer {
                    display: flex;
                    gap: 20px;
                    flex-wrap: wrap;
                    margin-top: 15px;
                }

                #imageContainer img {
                    object-fit: cover;
                }
            </style>

            <script>
                const pictureInput = document.getElementById('picture');
                const imageContainer = document.getElementById('imageContainer');

                pictureInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const sizes = [100, 200, 300];
                        imageContainer.innerHTML = ''; // Limpia el contenedor

                        sizes.forEach(size => {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.width = size;
                            img.height = size;
                            img.style.objectFit = 'cover';
                            imageContainer.appendChild(img);
                        });
                    }
                });
            </script>


            <div>
                <label for="nationality">Nacionalidad:</label>
                <select id="nationality" name="nationality" required>
                    <?php
                    $paises = array("Antigua y Barbuda", "Argentina", "Bahamas", "Barbados", "Belice", "Bolivia", "Brasil", "Canadá", "Chile", "Colombia", "Costa Rica", "Cuba", "Dominica", "Ecuador", "El Salvador", "Estados Unidos", "Granada", "Guatemala", "Guyana", "Haití", "Honduras", "Jamaica", "México", "Nicaragua", "Panamá", "Paraguay", "Perú", "República Dominicana", "San Cristóbal y Nieves", "San Vicente y las Granadinas", "Santa Lucía", "Surinam", "Trinidad y Tobago", "Uruguay", "Venezuela");
                    foreach ($paises as $pais) {
                        echo "<option value=\"$pais\">$pais</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
            <div>
                <button class="btn" type="submit">Guardar cambios</button>
            </div>
        </form>


    </div>

    <!-- Después del formulario, agregar: -->
    <div class="datos-actuales">
        <h2>Datos Actuales</h2>
        <?php
        $query = "SELECT * FROM formulario_datos ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->query($query);
        $datos = $resultado->fetch_assoc();

        if ($datos): ?>
            <div class="datos-container">
                <div class="dato-item">
                    <strong>Género:</strong>
                    <span><?= $datos['genero'] == 'male' ? 'Hombre' : 'Mujer' ?></span>
                </div>

                <div class="dato-item">
                    <strong>Título:</strong>
                    <span><?= $datos['titulo'] == 'mr' ? 'Sr.' : 'Sra.' ?></span>
                </div>

                <div class="dato-item">
                    <strong>Nombre completo:</strong>
                    <span><?= htmlspecialchars($datos['nombre_completo'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Usuario:</strong>
                    <span><?= htmlspecialchars($datos['username'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Ubicación:</strong>
                    <span>
                        <?= htmlspecialchars($datos['ciudad'] ?? '') ?>,
                        <?= htmlspecialchars($datos['estado'] ?? '') ?>,
                        <?= htmlspecialchars($datos['pais'] ?? '') ?>
                    </span>
                </div>

                <div class="dato-item">
                    <strong>Código Postal:</strong>
                    <span><?= htmlspecialchars($datos['codigo_postal'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Coordenadas:</strong>
                    <span>
                        Lat: <?= htmlspecialchars($datos['latitud'] ?? '') ?>,
                        Long: <?= htmlspecialchars($datos['longitud'] ?? '') ?>
                    </span>
                </div>

                <div class="dato-item">
                    <strong>Dirección:</strong>
                    <span><?= htmlspecialchars($datos['direccion'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Zona Horaria:</strong>
                    <span><?= htmlspecialchars($datos['diferencia_horaria'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Correo:</strong>
                    <span><?= htmlspecialchars($datos['correo'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Fecha de Nacimiento:</strong>
                    <span><?= htmlspecialchars($datos['fecha_nacimiento'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Edad:</strong>
                    <span><?= htmlspecialchars($datos['edad'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Identificador:</strong>
                    <span><?= htmlspecialchars($datos['identificador'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Teléfono móvil:</strong>
                    <span><?= htmlspecialchars($datos['telefono_movil'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Teléfono casa:</strong>
                    <span><?= htmlspecialchars($datos['telefono_casa'] ?? '') ?></span>
                </div>

                <div class="dato-item">
                    <strong>Nacionalidad:</strong>
                    <span><?= htmlspecialchars($datos['nacionalidad'] ?? '') ?></span>
                </div>

                <?php if (!empty($datos['foto'])): ?>
                    <div class="dato-item fotos">
                        <strong>Foto actual:</strong>
                        <div class="imagenes-container">
                            <?php
                            $imagen_base64 = base64_encode($datos['foto']);
                            $sizes = [100, 200, 300];
                            foreach ($sizes as $size): ?>
                                <img src="data:image/jpeg;base64,<?= $imagen_base64 ?>" width="<?= $size ?>" height="<?= $size ?>"
                                    alt="Foto de perfil <?= $size ?>x<?= $size ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>No hay datos guardados aún.</p>
        <?php endif; ?>
    </div>

    <style>
        .datos-actuales {
            position: fixed;
            top: 80px;
            right: 20px;
            width: 400px;
            height: calc(100vh - 100px);
            overflow-y: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .datos-actuales h2 {
            color: var(--secondary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }

        .dato-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .dato-item strong {
            display: block;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .dato-item span {
            color: var(--cuaternary);
        }

        .imagenes-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 10px;
        }

        .imagenes-container img {
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* Ajustar el formulario para que no se solape */
        .formulario {
            margin-right: 440px;
        }
    </style>

    <!-- Agregar la tabla GOMS KLM -->
    <div>
        <h2>Tabla GOMS KLM</h2>
        <table id="metricsTable">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>K</th>
                    <th>P</th>
                    <th>H</th>
                    <th>M</th>
                    <th>B</th>
                    <th>Scrolling</th>
                    <th>Total (Segundos)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Las filas se agregarán con JavaScript -->
            </tbody>
        </table>
    </div>
    <br><br><br>

    <!-- Agregar estilos para la tabla -->
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin-left: 230px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid var(--secondary);
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: var(--tertiary);
        }
    </style>

    <!-- Agregar el script de métricas antes del cierre del body -->
    <script>
        // Inicializar métricas
        const metrics = {
            gender: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            title: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            name: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            username: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            city: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            state: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            country: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            postcode: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            latitude: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            longitude: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            description: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            timezone: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            offset: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            email: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            dob: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            age: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            identifier: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            phone: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            house_phone: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            picture: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 },
            nationality: { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0 }
        };

        let lastInteractionType = 'keyboard';
        let lastFocusedInput = null;

        // Eventos de seguimiento
        document.addEventListener('mousemove', (e) => {
            const target = e.target;
            if (target.id in metrics) {
                metrics[target.id].p++;
                updateTable();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (lastFocusedInput) {
                if (lastInteractionType === 'mouse') {
                    metrics[lastFocusedInput].h++;
                    lastInteractionType = 'keyboard';
                }

                if (e.key !== 'Tab' && e.key !== 'Shift') {
                    metrics[lastFocusedInput].k++;
                }
                updateTable();
            }
        });

        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('focus', (e) => {
                lastFocusedInput = e.target.id;
            });

            element.addEventListener('click', (e) => {
                const id = e.target.id;
                if (id in metrics) {
                    metrics[id].b++;
                    metrics[id].m++;
                    updateTable();
                }
            });
        });

        window.addEventListener('scroll', () => {
            if (lastFocusedInput && lastFocusedInput in metrics) {
                metrics[lastFocusedInput].s++;
                updateTable();
            }
        });

        function updateTable() {
            const tbody = document.querySelector('#metricsTable tbody');
            tbody.innerHTML = '';

            let totals = { k: 0, p: 0, h: 0, m: 0, b: 0, s: 0, total: 0 };

            for (const [key, value] of Object.entries(metrics)) {
                const total = calculateTotal(value);
                const row = `
                <tr>
                    <td>${key}</td>
                    <td>${value.k}</td>
                    <td>${value.p}</td>
                    <td>${value.h}</td>
                    <td>${value.m}</td>
                    <td>${value.b}</td>
                    <td>${value.s}</td>
                    <td>${total}</td>
                </tr>
            `;
                tbody.innerHTML += row;

                totals.k += value.k;
                totals.p += value.p;
                totals.h += value.h;
                totals.m += value.m;
                totals.b += value.b;
                totals.s += value.s;
                totals.total += parseFloat(total);
            }

            tbody.innerHTML += `
            <tr>
                <td><strong>Total</strong></td>
                <td>${totals.k}</td>
                <td>${totals.p}</td>
                <td>${totals.h}</td>
                <td>${totals.m}</td>
                <td>${totals.b}</td>
                <td>${totals.s}</td>
                <td><strong>${totals.total.toFixed(2)}</strong></td>
            </tr>
        `;
        }

        function calculateTotal(metrics) {
            const { k, p, h, m, b, s } = metrics;
            return (k * 0.28 + p * 0.01 + h * 0.4 + m * 1.2 + b * 0.1 + s * 0.1).toFixed(2);
        }

        // Inicializar la tabla
        updateTable();
    </script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
    <script src="mapa.js"></script>
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

</html>