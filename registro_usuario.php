<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se han enviado los datos a través de POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $identificador = $_POST['identificador'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];

    // Preparar la consulta SQL para insertar en la tabla Usuarios
    $sql = "INSERT INTO Usuarios (Identificador, Nombres, Apellidos) VALUES (?, ?, ?)";

    // Preparar la sentencia para evitar inyecciones SQL
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros con los valores
        $stmt->bind_param("sss", $identificador, $nombres, $apellidos);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
    
    // Cerrar la conexión
    //$conexion->close();
}
?>
<!-- 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="POST" action="registro_usuario.php">
        <label for="identificador">Identificador:</label>
        <input type="text" name="identificador" required><br>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br>

        <input type="submit" value="Registrar Usuario">
    </form>
</body>
</html> -->