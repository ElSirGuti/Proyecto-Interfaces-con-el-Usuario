<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'login_register_db';
$user = 'root';
$password = '123456789';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos del formulario
        $genero = $_POST['gender'];
        $titulo = $_POST['title'];
        $nombre_completo = $_POST['nombre_completo'];
        $username = $_POST['username'];
        $ciudad = $_POST['city'];
        $estado = $_POST['state'];
        $pais = $_POST['country'];
        $codigo_postal = $_POST['postcode'];
        $latitud = $_POST['latitude'];
        $longitud = $_POST['longitude'];
        $direccion = $_POST['description'];
        $diferencia_horaria = $_POST['timezone'];
        $zona_horaria = $_POST['offset'];
        $correo = $_POST['correo'];
        $fecha_nacimiento = $_POST['dob'];
        $edad = $_POST['age'];
        $identificador = $_POST['identifier'];
        $telefono_movil = $_POST['phone'];
        $telefono_casa = $_POST['house_phone'];
        $foto = file_get_contents($_FILES['picture']['tmp_name']);
        $nacionalidad = $_POST['nationality'];

        // Insertar datos en la base de datos
        $sql = "INSERT INTO formulario_datos (genero, titulo, nombre_completo, username, ciudad, estado, pais, codigo_postal, latitud, longitud, direccion, diferencia_horaria, zona_horaria, correo, fecha_nacimiento, edad, identificador, telefono_movil, telefono_casa, foto, nacionalidad)
                VALUES (:genero, :titulo, :nombre_completo, :username, :ciudad, :estado, :pais, :codigo_postal, :latitud, :longitud, :direccion, :diferencia_horaria, :zona_horaria, :correo, :fecha_nacimiento, :edad, :identificador, :telefono_movil, :telefono_casa, :foto, :nacionalidad)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':genero' => $genero,
            ':titulo' => $titulo,
            ':nombre_completo' => $nombre_completo,
            ':username' => $username,
            ':ciudad' => $ciudad,
            ':estado' => $estado,
            ':pais' => $pais,
            ':codigo_postal' => $codigo_postal,
            ':latitud' => $latitud,
            ':longitud' => $longitud,
            ':direccion' => $direccion,
            ':diferencia_horaria' => $diferencia_horaria,
            ':zona_horaria' => $zona_horaria,
            ':correo' => $correo,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':edad' => $edad,
            ':identificador' => $identificador,
            ':telefono_movil' => $telefono_movil,
            ':telefono_casa' => $telefono_casa,
            ':foto' => $foto,
            ':nacionalidad' => $nacionalidad
        ]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar los datos del formulario
    $id = 1; // El id del usuario que deseas actualizar (puedes obtenerlo de la sesión o un campo oculto)
    $genero = $_POST['gender'];  // Asegúrate de que la columna en la base de datos se llama 'genero'
    $titulo = $_POST['title'];
    $nombre_completo = $_POST['nombre_completo'];
    $username = $_POST['username'];
    $ciudad = $_POST['city'];
    $estado = $_POST['state'];
    $pais = $_POST['country'];
    $codigo_postal = $_POST['postcode'];
    $latitud = $_POST['latitude'];
    $longitud = $_POST['longitude'];
    $direccion = $_POST['description'];
    $diferencia_horaria = $_POST['timezone'];
    $zona_horaria = $_POST['offset'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['dob'];
    $edad = $_POST['age'];
    $identificador = $_POST['identifier'];
    $telefono_movil = $_POST['phone'];
    $telefono_casa = $_POST['house_phone'];
    $foto = file_get_contents($_FILES['picture']['tmp_name']);
    $nacionalidad = $_POST['nationality'];

    // Preparar la consulta SQL para actualizar los datos
    $stmt = $pdo->prepare("
        UPDATE formulario_datos SET
            genero = :genero,
            titulo = :titulo,
            nombre_completo = :nombre_completo,
            username = :username,
            ciudad = :ciudad,
            estado = :estado,
            pais = :pais,
            codigo_postal = :codigo_postal,
            latitud = :latitud,
            longitud = :longitud,
            direccion = :direccion,
            diferencia_horaria = :diferencia_horaria,
            zona_horaria = :zona_horaria,
            correo = :correo,
            fecha_nacimiento = :fecha_nacimiento,
            edad = :edad,
            identificador = :identificador,
            telefono_movil = :telefono_movil,
            telefono_casa = :telefono_casa,
            foto = :foto,
            nacionalidad = :nacionalidad
        WHERE id = :id
    ");

    // Ejecutar la consulta con los datos
    $stmt->execute([
        ':genero' => $genero,
        ':titulo' => $titulo,
        ':nombre_completo' => $nombre_completo,
        ':username' => $username,
        ':ciudad' => $ciudad,
        ':estado' => $estado,
        ':pais' => $pais,
        ':codigo_postal' => $codigo_postal,
        ':latitud' => $latitud,
        ':longitud' => $longitud,
        ':direccion' => $direccion,
        ':diferencia_horaria' => $diferencia_horaria,
        ':zona_horaria' => $zona_horaria,
        ':correo' => $correo,
        ':fecha_nacimiento' => $fecha_nacimiento,
        ':edad' => $edad,
        ':identificador' => $identificador,
        ':telefono_movil' => $telefono_movil,
        ':telefono_casa' => $telefono_casa,
        ':foto' => $foto,
        ':nacionalidad' => $nacionalidad,
        ':id' => $id
    ]);

    // Verificar si la actualización fue exitosa
    if ($stmt->rowCount() > 0) {
        // Si fue exitoso, redirige a la página anterior
        header("Location: editar_perfil.php");
        exit; // Asegúrate de que no se ejecute más código después de la redirección
    } else {
        // Si no se actualizó nada, puedes redirigir con un mensaje de error o hacer algo más
        echo "Error al actualizar los datos.";
    }
}



?>