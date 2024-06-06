<?php
include 'conexion/db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "UPDATE eventos 
            SET titulo='$titulo', descripcion='$descripcion', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', categoria_id='$categoria_id'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Evento actualizado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    $sql = "SELECT * FROM eventos WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Evento no encontrado";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Evento</title>
</head>
<body>
    <h1>Editar Evento</h1>
    <form method="post" action="">
        Título: <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required><br>
        Descripción: <textarea name="descripcion" required><?php echo $row['descripcion']; ?></textarea><br>
        Fecha de inicio: <input type="datetime-local" name="fecha_inicio" value="<?php echo str_replace(' ', 'T', $row['fecha_inicio']); ?>" required><br>
        Fecha de fin: <input type="datetime-local" name="fecha_fin" value="<?php echo str_replace(' ', 'T', $row['fecha_fin']); ?>"><br>
        Categoría: 
        <select name="categoria_id" required>
            <?php
            $sql = "SELECT id, nombre FROM categorias";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($cat_row = $result->fetch_assoc()) {
                    $selected = ($cat_row['id'] == $row['categoria_id']) ? 'selected' : '';
                    echo "<option value='".$cat_row["id"]."' $selected>".$cat_row["nombre"]."</option>";
                }
            }
            ?>
        </select><br>
        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php">Volver</a>
</body>
</html>
