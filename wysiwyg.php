<html>
<head>
    <title>WYSIWYG Editor</title>
    <script src="wysiwyg.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />

</head>

<body>

    <header class="header">

        <div id="menu-btn" class="fas fa-bars"></div>

        <a href="#" class="logo"><span>carbon</span>works</a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#vehicles">vehicles</a>
            <a href="#services">services</a>
            <a href="#featured">featured</a>
            <a href="#reviews">reviews</a>
            <a href="#contact">contact</a>
            <a href="#wysiwyg">Wysiwyg</a>
            
            
        </nav>

        <div id="login-btn">
            <a href="login.php">
                <button class="btn">login</button>
            </a>
            <i class="far fa-user"></i>
        </div>

    </header>

     <header class="header">

        <div id="menu-btn" class="fas fa-bars"></div>

        <a href="#" class="logo"><span>carbon</span>works</a>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="index.php">vehicles</a>
            <a href="index.php">services</a>
            <a href="index.php">featured</a>
            <a href="index.php">reviews</a>
            <a href="index.php">contact</a>
            
            
        </nav>

        <div id="login-btn">
            <a href="login.php">
                <button class="btn">login</button>
            </a>
            <i class="far fa-user"></i>
        </div>

    </header>
    <br><br><br><br><br><br><br><br>
    <div id="editor">
    Términos y Condiciones de Uso <br>
Por favor, lea cuidadosamente estos Términos y Condiciones de Uso ("Términos") antes
de utilizar el Sitio. Al acceder o utilizar el Sitio, usted acepta quedar vinculado/a por estos
Términos. Si no está de acuerdo con alguno de ellos, no utilice el Sitio.<br>
Uso del Sitio<br>
-Usted se compromete a utilizar el Sitio de conformidad con la ley, la moral y el
orden público, y a no emplear el Sitio para actividades ilícitas o perjudiciales.<br>
-Queda estrictamente prohibido intentar acceder, alterar, o dañar cualquier parte
del Sitio o sus sistemas de seguridad.<br>
Propiedad Intelectual<br>
Todos los derechos de propiedad intelectual del contenido del Sitio, incluidos textos,
gráficos, logotipos, imágenes, software y diseños, son propiedad exclusiva de [Nombre
de la Página Web] o de sus licenciantes.<br>
-Usted no está autorizado/a a copiar, reproducir, distribuir, modificar, o utilizar el
contenido del Sitio sin el permiso previo por escrito de [carbonworks.com].<br>
Cuentas de Usuario<br>
-Para acceder a ciertas funciones, puede ser necesario crear una cuenta. Usted
es responsable de mantener la confidencialidad de sus credenciales y de todas las
actividades realizadas desde su cuenta.<br>
-Nos reservamos el derecho de suspender o cancelar cuentas que violen estos
Términos o que se utilicen de manera fraudulenta.<br>
Privacidad<br>
-La recopilación y uso de información personal están sujetos a nuestra [Política
de Privacidad], que forma parte de estos Términos.<br>
Limitación de Responsabilidad<br>
-El Sitio se proporciona "tal cual" y "según disponibilidad". No garantizamos que
el Sitio esté libre de errores o interrupciones.<br>
-CARBONWORKS no será responsable de daños directos, indirectos,
incidentales, o consecuentes derivados del uso o incapacidad de uso del Sitio.<br>
Enlaces a Terceros<br>
-El Sitio puede contener enlaces a sitios web de terceros. No somos responsables
del contenido, políticas o prácticas de dichos sitios.<br>
Modificaciones<br>
-Nos reservamos el derecho de modificar estos Términos en cualquier momento.
Las modificaciones serán efectivas desde su publicación en el Sitio.<br>
-Se recomienda revisar estos Términos periódicamente para estar informado/a de
cualquier cambio.<br>
Ley Aplicable y Jurisdicción<br>
-Estos Términos se rigen por las leyes de Venezuela.<br>
-Cualquier disputa relacionada con el Sitio será sometida a la jurisdicción de los
tribunales del estado de Carabobo.<br>
Contacto<br>
-Si tiene alguna pregunta sobre estos Términos, puede contactarnos a través de
[carbonworks.com].<br>
        <p><br /></p>
    </div>

    <input type="button" onclick="jsSave()" value="Guardar">

</body>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<script>
    const quill = new Quill('#editor', {
      theme: 'snow'
    });

    function jsSave(){
        let contenido=quill.container.firstChild.innerHTML; 
        fetch("save.php?contenido=" + contenido);
        alert("Se ha guardado")
    }
  </script>

</html>