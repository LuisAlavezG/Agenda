<?php
include 'db.php';

$sql = "SELECT id, titulo AS title, descripcion, fecha_inicio AS start, fecha_fin AS end FROM eventos";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);

$conn->close();
?>
