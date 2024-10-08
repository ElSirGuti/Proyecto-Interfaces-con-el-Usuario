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
            --cuaternary: #666;
        }

        .container {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        label{
            font-size: medium;
        }

        .titulo {
            font-size: 2.5rem;
            margin: auto;
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
        <h1 class="">Personalization Panel</h1>
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
    <div class="container" style="margin-left: 230px">
        <!-- Color picker form -->
        <form id="color-picker-form">
            <label for="primary-color">Primary Color:</label>
            <input type="color" id="primary-color" value="#f9d806">
            <div id="primary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid #ccc; background-color: #f9d806;"></div>
            <br>
            <label for="secondary-color">Secondary Color:</label>
            <input type="color" id="secondary-color" value="#130F40">
            <div id="secondary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid #ccc; background-color: #130F40;"></div>
            <br>
            <label for="tertiary-color">Tertiary Color:</label>
            <input type="color" id="tertiary-color" value="#ffee80">
            <div id="tertiary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid #ccc; background-color: #ffee80;"></div>
            <br>
            <label for="cuaternary-color">Cuaternary Color:</label>
            <input type="color" id="cuaternary-color" value="#666">
            <div id="cuaternary-color-preview"
                style="width: 20px; height: 20px; border: 1px solid #ccc; background-color: #666;"></div>
            <br>
            <button id="save-colors" class="btn">Save Colors</button>
        </form>

        <!-- Preview box -->
        <div class="preview-box">
            <h1 id="preview-h1" style="color: var(--primary)">Heading 1</h1>
            <h2 id="preview-h2" style="color: var(--secondary)">Heading 2</h2>
            <h3 id="preview-h3" style="color: var(--tertiary)">Heading 3</h3>
            <p id="preview-p" style="color: var(--cuaternary)">This is a paragraph of text.</p>
        </div>
    </div>

    <!-- Script to handle color changes -->
    <script>
        const primaryColorInput = document.getElementById('primary-color');
        const secondaryColorInput = document.getElementById('secondary-color');
        const tertiaryColorInput = document.getElementById('tertiary-color');
        const cuaternaryColorInput = document.getElementById('cuaternary-color');
        const primaryColorPreview = document.getElementById('primary-color-preview');
        const secondaryColorPreview = document.getElementById('secondary-color-preview');
        const tertiaryColorPreview = document.getElementById('tertiary-color-preview');
        const cuaternaryColorPreview = document.getElementById('cuaternary-color-preview');
        const saveColorsButton = document.getElementById('save-colors');
        const root = document.documentElement;
        const previewH1 = document.getElementById('preview-h1');
        const previewH2 = document.getElementById('preview-h2');
        const previewH3 = document.getElementById('preview-h3');
        const previewP = document.getElementById('preview-p');
        const testParagraph = document.getElementById('test-paragraph');

        // Function to update colors
        function updateColors() {
            root.style.setProperty('--primary', primaryColorInput.value);
            root.style.setProperty('--secondary', secondaryColorInput.value);
            root.style.setProperty('--tertiary', tertiaryColorInput.value);
            root.style.setProperty('--cuaternary', cuaternaryColorInput.value);

            // Update preview elements
            primaryColorPreview.style.backgroundColor = primaryColorInput.value;
            secondaryColorPreview.style.backgroundColor = secondaryColorInput.value;
            tertiaryColorPreview.style.backgroundColor = tertiaryColorInput.value;
            cuaternaryColorPreview.style.backgroundColor = cuaternaryColorInput.value;

            // Update headings and paragraph text
            previewH1.style.color = primaryColorInput.value;
            previewH2.style.color = secondaryColorInput.value;
            previewH3.style.color = tertiaryColorInput.value;
            previewP.style.color = cuaternaryColorInput.value;
            testParagraph.style.color = cuaternaryColorInput.value;

            // Store color values in local storage
            localStorage.setItem('primaryColor', primaryColorInput.value);
            localStorage.setItem('secondaryColor', secondaryColorInput.value);
            localStorage.setItem('tertiaryColor', tertiaryColorInput.value);
            localStorage.setItem('cuaternaryColor', cuaternaryColorInput.value);

            // Update colors on all pages
            updateColorsOnAllPages();
        }

        // Function to load colors from local storage
        function loadColors() {
            const primaryColor = localStorage.getItem('primaryColor');
            const secondaryColor = localStorage.getItem('secondaryColor');
            const tertiaryColor = localStorage.getItem('tertiaryColor');
            const cuaternaryColor = localStorage.getItem('cuaternaryColor');

            if (primaryColor) {
                primaryColorInput.value = primaryColor;
                root.style.setProperty('--primary', primaryColor);
                primaryColorPreview.style.backgroundColor = primaryColor;
                previewH1.style.color = primaryColor;
            }

            if (secondaryColor) {
                secondaryColorInput.value = secondaryColor;
                root.style.setProperty('--secondary', secondaryColor);
                secondaryColorPreview.style.backgroundColor = secondaryColor;
                previewH2.style.color = secondaryColor;
            }

            if (tertiaryColor) {
                tertiaryColorInput.value = tertiaryColor;
                root.style.setProperty('--tertiary', tertiaryColor);
                tertiaryColorPreview.style.backgroundColor = tertiaryColor;
                previewH3.style.color = tertiaryColor;
            }

            if (cuaternaryColor) {
                cuaternaryColorInput.value = cuaternaryColor;
                root.style.setProperty('--cuaternary', cuaternaryColor);
                cuaternaryColorPreview.style.backgroundColor = cuaternaryColor;
                previewP.style.color = cuaternaryColor;
                testParagraph.style.color = cuaternaryColor;
            }
        }

        // Add event listener to save colors button
        saveColorsButton.addEventListener('click', updateColors);

        // Update colors on input change
        primaryColorInput.addEventListener('input', updateColors);
        secondaryColorInput.addEventListener('input', updateColors);
        tertiaryColorInput.addEventListener('input', updateColors);
        cuaternaryColorInput.addEventListener('input', updateColors);

        // Load colors from local storage on page load
        loadColors();
    </script>

</body>

</html>