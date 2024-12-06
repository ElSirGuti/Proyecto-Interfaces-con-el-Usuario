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
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        :root {
            --primary: #f9d806;
            --secondary: #130F40;
            --tertiary: #ffee80;
            --cuaternary: #666666;
            --background: #ffffff;
        }

        body {
            background-color: var(--background, #ffffff);
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
            margin-left: 230px;
            width: calc(200px + 30%);
            color: var(--secondary);
        }

        .subtitulo {
            margin-left: 230px;
            width: calc(200px + 30%);
            color: var(--secondary);
        }

        .preview-box {
            border: 1px solid var(--cuaternary);
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
    </style>
</head>

<body>
    <div class="titulo" style="">
        <h1 class="" id="main-h1">Personalization Panel</h1>
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
    <div class="subtitulo" style="">
        <h2 id="main-h2">Colors</h2>
    </div>
    <div class="container" style="margin-left: 230px">
        <!-- Color picker form -->
        <form id="color-picker-form">
            <label for="primary-color">Primary Color:</label>
            <input type="color" id="primary-color" value="#f9d806">
            <div id="primary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid var(--cuaternary); background-color: #f9d806;">
            </div>
            <br>
            <label for="secondary-color">Secondary Color:</label>
            <input type="color" id="secondary-color" value="#130F40">
            <div id="secondary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid var(--cuaternary); background-color: #130F40;">
            </div>
            <br>
            <label for="tertiary-color">Tertiary Color:</label>
            <input type="color" id="tertiary-color" value="#ffee80">
            <div id="tertiary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid var(--cuaternary); background-color: #ffee80;">
            </div>
            <br>
            <label for="cuaternary-color">Cuaternary Color:</label>
            <input type="color" id="cuaternary-color" value="#666">
            <div id="cuaternary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid var(--cuaternary); background-color: #666;"></div>
            <br>
            <label for="background-color">Background Color:</label>
            <input type="color" id="background-color" value="#fff">
            <div id="background-color-preview"
                style="width: 20px; height: 20px; border: 1px solid var(--cuaternary); background-color: #fff;"></div>
            <br>
            <button type="submit" id="save-colors" class="btn">Save Colors</button>
        </form>

        <!-- Preview box -->
        <div class="preview-box">
            <h1 id="preview-h1" style="color: var(--primary)">Heading 1</h1>
            <h2 id="preview-h2" style="color: var(--secondary)">Heading 2</h2>
            <h3 id="preview-h3" style="color: var(--tertiary)">Heading 3</h3>
            <p id="preview-p" style="color: var(--cuaternary)">This is a paragraph of text.</p>
        </div>

    </div>

    <br><br>
    <div class="subtitulo" style="">
        <h2 id="main-h2-2">Font Sizes</h2>
    </div>

    <br>
    <!-- Font size form -->
    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <form id="font-size-form">
            <div class="form-group">
                <label for="label-size">Label Size (px):</label>
                <input type="number" id="label-size" value="16" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="h1-size">Heading 1 Size (px):</label>
                <input type="number" id="h1-size" value="24" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="h2-size">Heading 2 Size (px):</label>
                <input type="number" id="h2-size" value="18" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="h3-size">Heading 3 Size (px):</label>
                <input type="number" id="h3-size" value="14" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="p-size">Paragraph Size (px):</label>
                <input type="number" id="p-size" value="13" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="sidebar-size">Sidebar Text Size (px):</label>
                <input type="number" id="sidebar-size" value="12" min="10" max="72">
            </div>
            <br>
            <div class="form-group">
                <label for="button-size">Button Text Size (px):</label>
                <input type="number" id="button-size" value="16" min="10" max="72">
            </div>
            <br>
            <button type="submit" id="save-sizes" class="btn">Save Font Sizes</button>
        </form>
    </div>

    <br>
    <br>
    <div class="subtitulo" style="">
        <h2 id="main-h2-3">Font</h2>
    </div>

    <div class="container" style="margin-left: 230px; flex-direction: column; align-items: flex-start;">
        <input type="file" id="font-upload" accept=".ttf" style="margin-top: 10px;">
        <div style="margin-top: 10px;">
            <button class="btn" onclick="changeFont()">Change Font</button>
            <button class="btn" onclick="resetFont()">Default Font</button>
        </div>
    </div>

    <!-- Script to handle color changes -->
    <script>
        const primaryColorInput = document.getElementById('primary-color');
        const secondaryColorInput = document.getElementById('secondary-color');
        const tertiaryColorInput = document.getElementById('tertiary-color');
        const cuaternaryColorInput = document.getElementById('cuaternary-color');
        const backgroundColorInput = document.getElementById('background-color');
        const primaryColorPreview = document.getElementById('primary-color-preview');
        const secondaryColorPreview = document.getElementById('secondary-color-preview');
        const tertiaryColorPreview = document.getElementById('tertiary-color-preview');
        const cuaternaryColorPreview = document.getElementById('cuaternary-color-preview');
        const backgroundColorPreview = document.getElementById('background-color-preview');
        const saveColorsButton = document.getElementById('save-colors');
        const root = document.documentElement;
        const previewH1 = document.getElementById('preview-h1');
        const previewH2 = document.getElementById('preview-h2');
        const previewH3 = document.getElementById('preview-h3');
        const previewP = document.getElementById('preview-p');
        const testParagraph = document.getElementById('test-paragraph');

        // Función para actualizar preview en vivo
        function updatePreview() {
            // Actualizar las variables CSS
            root.style.setProperty('--primary', primaryColorInput.value);
            root.style.setProperty('--secondary', secondaryColorInput.value);
            root.style.setProperty('--tertiary', tertiaryColorInput.value);
            root.style.setProperty('--cuaternary', cuaternaryColorInput.value);

            // Actualizar el color de fondo explícitamente
            const bgColor = backgroundColorInput.value || '#ffffff';
            document.body.style.backgroundColor = bgColor;
            root.style.setProperty('--background', bgColor);

            // Actualizar previews
            primaryColorPreview.style.backgroundColor = primaryColorInput.value;
            secondaryColorPreview.style.backgroundColor = secondaryColorInput.value;
            tertiaryColorPreview.style.backgroundColor = tertiaryColorInput.value;
            cuaternaryColorPreview.style.backgroundColor = cuaternaryColorInput.value;
            backgroundColorPreview.style.backgroundColor = bgColor;

            // Actualizar textos de preview
            previewH1.style.color = primaryColorInput.value;
            previewH2.style.color = secondaryColorInput.value;
            previewH3.style.color = tertiaryColorInput.value;
            previewP.style.color = cuaternaryColorInput.value;
            // document.body.style.backgroundColor = backgroundColorInput.value;
        }

        // Función para guardar colores
        function saveColors(event) {
            if (event) {
                event.preventDefault();
            }

            // Guardar en localStorage
            localStorage.setItem('primaryColor', primaryColorInput.value);
            localStorage.setItem('secondaryColor', secondaryColorInput.value);
            localStorage.setItem('tertiaryColor', tertiaryColorInput.value);
            localStorage.setItem('cuaternaryColor', cuaternaryColorInput.value);
            localStorage.setItem('backgroundColor', backgroundColorInput.value);

            const formData = new FormData();
            formData.append('tipo', 'colores');
            formData.append('primary', primaryColorInput.value);
            formData.append('secondary', secondaryColorInput.value);
            formData.append('tertiary', tertiaryColorInput.value);
            formData.append('cuaternary', cuaternaryColorInput.value);
            formData.append('background', backgroundColorInput.value);

            fetch('guardar_personalizacion.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.text(); // Cambiamos a text() en lugar de json()
                })
                .then(data => {
                    console.log('Respuesta del servidor:', data); // Ver la respuesta completa
                    try {
                        const jsonData = JSON.parse(data);
                        if (jsonData.success) {
                            alert('¡Colores guardados correctamente!');
                        } else {
                            alert('Error al guardar los colores: ' + jsonData.message);
                        }
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        alert('Error al procesar la respuesta del servidor');
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    alert('Error al guardar los colores: ' + error.message);
                });
        }

        // Event listeners para preview en vivo
        primaryColorInput.addEventListener('input', updatePreview);
        secondaryColorInput.addEventListener('input', updatePreview);
        tertiaryColorInput.addEventListener('input', updatePreview);
        cuaternaryColorInput.addEventListener('input', updatePreview);
        backgroundColorInput.addEventListener('input', updatePreview);

        // Event listener para guardar colores
        document.getElementById('color-picker-form').addEventListener('submit', saveColors);

        // Función para cargar colores guardados
        function loadColors() {
            const primaryColor = localStorage.getItem('primaryColor');
            const secondaryColor = localStorage.getItem('secondaryColor');
            const tertiaryColor = localStorage.getItem('tertiaryColor');
            const cuaternaryColor = localStorage.getItem('cuaternaryColor');
            const backgroundColor = localStorage.getItem('backgroundColor') || '#ffffff'; // Valor por defecto blanco

            if (primaryColor) primaryColorInput.value = primaryColor;
            if (secondaryColor) secondaryColorInput.value = secondaryColor;
            if (tertiaryColor) tertiaryColorInput.value = tertiaryColor;
            if (cuaternaryColor) cuaternaryColorInput.value = cuaternaryColor;
            if (backgroundColor) {
                backgroundColorInput.value = backgroundColor;
                document.body.style.backgroundColor = backgroundColor;
            }

            updatePreview();
        }

        // Cargar colores al iniciar la página
        document.addEventListener('DOMContentLoaded', loadColors);
    </script>

    <!-- Script to handle font changes -->
    <script src="font-changer.js"></script>

    <!-- Script to handle fontsize changes -->
    <script>
        // Obtener referencias a los nuevos inputs
        const h1SizeInput = document.getElementById('h1-size');
        const h2SizeInput = document.getElementById('h2-size');
        const h3SizeInput = document.getElementById('h3-size');
        const pSizeInput = document.getElementById('p-size');
        const labelSizeInput = document.getElementById('label-size');
        const sidebarSizeInput = document.getElementById('sidebar-size');
        const buttonSizeInput = document.getElementById('button-size');

        // Función para actualizar tamaños de texto en preview
        function updateFontSizes() {
            // Actualizar tamaños de preview
            previewH1.style.fontSize = `${h1SizeInput.value}px`;
            previewH2.style.fontSize = `${h2SizeInput.value}px`;
            previewH3.style.fontSize = `${h3SizeInput.value}px`;
            previewP.style.fontSize = `${pSizeInput.value}px`;

            // Actualizar tamaños de los títulos principales
            document.getElementById('main-h1').style.fontSize = `${h1SizeInput.value}px`;
            document.getElementById('main-h2').style.fontSize = `${h2SizeInput.value}px`;
            document.getElementById('main-h2-2').style.fontSize = `${h2SizeInput.value}px`;
            document.getElementById('main-h2-3').style.fontSize = `${h2SizeInput.value}px`;

            // Actualizar tamaño de labels del formulario
            const formLabels = document.querySelectorAll('.form-group label:first-child');
            formLabels.forEach(label => {
                label.style.fontSize = `${labelSizeInput.value}px`;
            });

            // Actualizar tamaño del texto del sidebar
            const sidebarLinks = document.querySelectorAll('.sidebar a');
            sidebarLinks.forEach(link => {
                link.style.fontSize = `${sidebarSizeInput.value}px`;
            });

            // Actualizar tamaño del texto de los botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.style.fontSize = `${buttonSizeInput.value}px`;
            });
        }

        // Función para guardar tamaños
        function saveFontSizes(event) {
            if (event) {
                event.preventDefault();
            }

            localStorage.setItem('labelSize', labelSizeInput.value);
            localStorage.setItem('h1Size', h1SizeInput.value);
            localStorage.setItem('h2Size', h2SizeInput.value);
            localStorage.setItem('h3Size', h3SizeInput.value);
            localStorage.setItem('pSize', pSizeInput.value);
            localStorage.setItem('sidebarSize', sidebarSizeInput.value);
            localStorage.setItem('buttonSize', buttonSizeInput.value);

            // Crear el FormData con los valores correctos
            const formData = new FormData();
            formData.append('tipo', 'tamanos');
            formData.append('label_size', document.getElementById('label-size').value);
            formData.append('h1_size', document.getElementById('h1-size').value);
            formData.append('h2_size', document.getElementById('h2-size').value);
            formData.append('h3_size', document.getElementById('h3-size').value);
            formData.append('p_size', document.getElementById('p-size').value);
            formData.append('sidebar_size', document.getElementById('sidebar-size').value);
            formData.append('button_size', document.getElementById('button-size').value);

            // Debug para ver qué se está enviando
            console.log('Enviando datos:', {
                tipo: 'tamanos',
                label_size: document.getElementById('label-size').value,
                h1_size: document.getElementById('h1-size').value,
                h2_size: document.getElementById('h2-size').value,
                h3_size: document.getElementById('h3-size').value,
                p_size: document.getElementById('p-size').value,
                sidebar_size: document.getElementById('sidebar-size').value,
                button_size: document.getElementById('button-size').value
            });

            fetch('guardar_tamano.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Respuesta del servidor:', data);
                    if (data.success) {
                        alert('¡Tamaños guardados correctamente!');
                    } else {
                        alert('Error al guardar los tamaños: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error completo:', error);
                    alert('Error al guardar los tamaños: ' + error.message);
                });
        }

        // Asegurarnos de que el evento se agrega correctamente
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('font-size-form');
            if (form) {
                form.addEventListener('submit', saveFontSizes);
            } else {
                console.error('No se encontró el formulario de tamaños');
            }
        });

        // Función para cargar tamaños guardados
        function loadFontSizes() {
            // Obtener los tamaños guardados del localStorage
            const labelSize = localStorage.getItem('labelSize');
            const h1Size = localStorage.getItem('h1Size');
            const h2Size = localStorage.getItem('h2Size');
            const h3Size = localStorage.getItem('h3Size');
            const pSize = localStorage.getItem('pSize');
            const sidebarSize = localStorage.getItem('sidebarSize');
            const buttonSize = localStorage.getItem('buttonSize');

            // Asignar los valores guardados a los inputs si existen
            if (labelSize) labelSizeInput.value = labelSize;
            if (h1Size) h1SizeInput.value = h1Size;
            if (h2Size) h2SizeInput.value = h2Size;
            if (h3Size) h3SizeInput.value = h3Size;
            if (pSize) pSizeInput.value = pSize;
            if (sidebarSize) sidebarSizeInput.value = sidebarSize;
            if (buttonSize) buttonSizeInput.value = buttonSize;

            // Actualizar los tamaños en la interfaz
            updateFontSizes();
        }

        h1SizeInput.addEventListener('input', updateFontSizes);
        h2SizeInput.addEventListener('input', updateFontSizes);
        h3SizeInput.addEventListener('input', updateFontSizes);
        pSizeInput.addEventListener('input', updateFontSizes);
        labelSizeInput.addEventListener('input', updateFontSizes);
        sidebarSizeInput.addEventListener('input', updateFontSizes);
        buttonSizeInput.addEventListener('input', updateFontSizes);

        // Event listener para guardar tamaños
        document.getElementById('font-size-form').addEventListener('submit', saveFontSizes);

        // Modificar el DOMContentLoaded existente para incluir loadFontSizes
        document.addEventListener('DOMContentLoaded', () => {
            loadColors();
            loadFontSizes();
        });
    </script>
</body>

</html>