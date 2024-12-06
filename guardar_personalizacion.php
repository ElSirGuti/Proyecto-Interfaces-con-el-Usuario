<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'php/conexion_be.php';

$response = ['success' => false, 'message' => '', 'debug' => []];

try {
    // Debug de los datos recibidos
    $response['debug']['post'] = $_POST;
    $response['debug']['connection'] = isset($conexion) ? 'Conexión establecida' : 'No hay conexión';

    if (!isset($_POST['tipo'])) {
        throw new Exception('No se recibió el tipo de datos');
    }

    if ($_POST['tipo'] === 'colores') {
        // Debug de los valores
        $response['debug']['valores'] = [
            'primary' => $_POST['primary'],
            'secondary' => $_POST['secondary'],
            'tertiary' => $_POST['tertiary'],
            'cuaternary' => $_POST['cuaternary'],
            'background' => $_POST['background']
        ];

        $sql = "INSERT INTO colores (primary_color, secondary_color, tertiary_color, cuaternary_color, background_color) 
                VALUES (?, ?, ?, ?, ?)";
        
        // Debug de la consulta SQL
        $response['debug']['sql'] = $sql;

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error en prepare: ' . $conexion->error);
        }

        $stmt->bind_param("sssss", 
            $_POST['primary'],
            $_POST['secondary'],
            $_POST['tertiary'],
            $_POST['cuaternary'],
            $_POST['background']
        );

        if (!$stmt->execute()) {
            throw new Exception('Error en execute: ' . $stmt->error);
        }

        $response['success'] = true;
        $response['message'] = 'Colores guardados correctamente';
        $response['debug']['affected_rows'] = $stmt->affected_rows;
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    $response['debug']['error'] = $e->getMessage();
}

echo json_encode($response);
exit;
?>