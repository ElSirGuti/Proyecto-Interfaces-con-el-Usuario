<?php
header('Content-Type: application/json');

try {
    if (!isset($_POST['audio_id']) || !isset($_POST['nuevo_orden'])) {
        throw new Exception('Faltan parámetros requeridos');
    }

    $audio_id = (int)$_POST['audio_id'];
    $nuevo_orden = (int)$_POST['nuevo_orden'];

    // Validar que el orden esté entre 1 y 3
    if ($nuevo_orden < 1 || $nuevo_orden > 3) {
        throw new Exception('El orden debe estar entre 1 y 3');
    }

    $conexion = new mysqli('localhost', 'root', '123456789', 'login_register_db');
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el orden actual del audio que queremos cambiar
    $stmt = $conexion->prepare("SELECT orden FROM audios WHERE id = ?");
    $stmt->bind_param('i', $audio_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $audio_actual = $resultado->fetch_assoc();
    
    if (!$audio_actual) {
        throw new Exception("No se encontró el audio especificado");
    }
    
    $orden_actual = $audio_actual['orden'];

    // Obtener el ID del audio que tiene el orden al que queremos cambiar
    $stmt = $conexion->prepare("SELECT id FROM audios WHERE orden = ?");
    $stmt->bind_param('i', $nuevo_orden);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $audio_a_intercambiar = $resultado->fetch_assoc();

    // Iniciar transacción para asegurar que ambas actualizaciones se realicen
    $conexion->begin_transaction();

    try {
        // Si hay un audio con el orden que queremos, actualizamos su orden
        if ($audio_a_intercambiar) {
            $stmt = $conexion->prepare("UPDATE audios SET orden = ? WHERE id = ?");
            $stmt->bind_param('ii', $orden_actual, $audio_a_intercambiar['id']);
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar el orden del audio existente");
            }
        }

        // Actualizar el orden del audio seleccionado
        $stmt = $conexion->prepare("UPDATE audios SET orden = ? WHERE id = ?");
        $stmt->bind_param('ii', $nuevo_orden, $audio_id);
        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar el orden");
        }

        // Confirmar los cambios
        $conexion->commit();
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        // Si hay error, revertir los cambios
        $conexion->rollback();
        throw $e;
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conexion->close();
?>