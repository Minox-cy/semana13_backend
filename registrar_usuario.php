<?php
require_once "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data["nombre"] ?? "";
$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

if ($nombre == "" || $email == "" || $password == "") {
    echo json_encode([
        "success" => false,
        "message" => "Todos los campos son requeridos"
    ]);
    exit();
}

$check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();

if ($check->get_result()->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email ya registrado"
    ]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO usuarios(nombre, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre, $email, $password);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Usuario registrado exitosamente",
        "user_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al registrar"
    ]);
}

$conn->close();
?>