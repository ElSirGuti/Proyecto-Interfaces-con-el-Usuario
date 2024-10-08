<?php  

    include 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo          = $_POST['correo'];
    $usuario         = $_POST['usuario'];
    $contrasena      = $_POST['contrasena'];

    $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena) 
              VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena')";

    $ejecutar = mysqli_query($conexion,$query);

    if($ejecutar){
        $_SESSION['usuario'] = $correo;
        echo '
            <script>
                alert("Usuario Almacenado Exitosamente!");
                window.location ="../dashboard.php";
            </script>
        ';
    }else{
        echo'
            <script>
                alert("Intentalo de Nuevo");
                window.location ="../login.php";
            </script>
        ';
    }

    mysqli_close($conexion);

?>