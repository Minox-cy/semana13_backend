<?php
require_once "config.php";

$sql = "SELECT id, nombre, email, fecha_registro FROM usuarios ORDER BY id DESC";
$result = $conn->query($sql);

$usuarios = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $usuarios
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error en la consulta: " . $conn->error
    ]);
}

$conn->close();
?>
