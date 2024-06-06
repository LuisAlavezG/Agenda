<?php
include 'conexion/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $titulo = $data->title;
    $descripcion = $data->description;
    $fecha_inicio = $data->start;
    $fecha_fin = $data->end;
    $usuario_id = 1; // Reemplaza esto con el ID del usuario autenticado
    $categoria_id = 1; // Reemplaza esto con la lógica para obtener la categoría

    $sql = "INSERT INTO eventos (usuario_id, titulo, descripcion, fecha_inicio, fecha_fin, categoria_id)
            VALUES ('$usuario_id', '$titulo', '$descripcion', '$fecha_inicio', '$fecha_fin', '$categoria_id')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["id" => $conn->insert_id]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }

    $conn->close();
}
?>
