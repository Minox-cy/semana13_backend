<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Variables de entorno de Railway
$host = getenv("MYSQLHOST");
$port = getenv("MYSQLPORT");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");

// Conexión
$conn = new mysqli($host, $user, $pass, $db, intval($port));

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Error de conexión: " . $conn->connect_error
    ]);
    exit();
}

$conn->set_charset("utf8mb4");

// Consulta a la tabla usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

if ($result) {
    $usuarios = [];
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
