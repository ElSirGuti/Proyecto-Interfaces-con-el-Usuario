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

    if ($_POST['tipo'] === 'tamanos') {
        // Debug de los valores
        $response['debug']['valores'] = [
            'label_size' => $_POST['label_size'],
            'h1_size' => $_POST['h1_size'],
            'h2_size' => $_POST['h2_size'],
            'h3_size' => $_POST['h3_size'],
            'p_size' => $_POST['p_size'],
            'sidebar_size' => $_POST['sidebar_size'],
            'button_size' => $_POST['button_size']
        ];

        $sql = "INSERT INTO tamanos (label_size, h1_size, h2_size, h3_size, p_size, sidebar_size, button_size) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Debug de la consulta SQL
        $response['debug']['sql'] = $sql;

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception('Error en prepare: ' . $conexion->error);
        }

        $stmt->bind_param("iiiiiii", 
            $_POST['label_size'],
            $_POST['h1_size'],
            $_POST['h2_size'],
            $_POST['h3_size'],
            $_POST['p_size'],
            $_POST['sidebar_size'],
            $_POST['button_size']
        );

        if (!$stmt->execute()) {
            throw new Exception('Error en execute: ' . $stmt->error);
        }

        $response['success'] = true;
        $response['message'] = 'Tamaños guardados correctamente';
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