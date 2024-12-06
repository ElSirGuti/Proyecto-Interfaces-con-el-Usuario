<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=wysiwyg",
    "root",
    ""
);
$post = $pdo->query("SELECT * FROM post ORDER BY id DESC LIMIT 1")->fetch();
echo $post["contenido"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminos y condiciones</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
</body>

</html>