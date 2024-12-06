<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "login_register_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// Leer los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit();
}

$name = $data['name'];
$fontBlob = base64_decode($data['fontBlob']);

// Insertar la fuente en la base de datos
$stmt = $conn->prepare("INSERT INTO fuentes (fuente_blob) VALUES (?)");
$stmt->bind_param('b', $fontBlob); // 'b' es para datos binarios
$stmt->send_long_data(0, $fontBlob);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
