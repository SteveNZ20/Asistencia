<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombre_sede = $_POST['nombre_sede'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];

    // Preparar la consulta SQL para insertar en la tabla Sedes
    $sql = "INSERT INTO Sedes (Nombre_Sede, Correo, Direccion) VALUES (?, ?, ?)";
    
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("sss", $nombre_sede, $correo, $direccion);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<p>Sede registrada exitosamente.</p>";
        } else {
            echo "<p>Error al registrar la sede: " . $conexion->error . "</p>";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "<p>Error al preparar la consulta: " . $conexion->error . "</p>";
    }
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Sede</title>
</head>
<body>
    <h2>Registrar Sede</h2>
    <form action="insertar_sedes.php" method="post">
        <label for="nombre_sede">Nombre de la Sede:</label>
        <input type="text" id="nombre_sede" name="nombre_sede" required><br><br>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br><br>
        
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br><br>
        
        <button type="submit">Registrar Sede</button>
    </form>
</body>
</html>