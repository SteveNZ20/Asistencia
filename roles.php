<?php
// Incluir archivo de conexión
include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol = $_POST['rol'];

    // Insertar el rol en la base de datos
    $sql = "INSERT INTO Roles (Rol) VALUES ('$rol')";

    if (mysqli_query($conexion, $sql)) {
        echo "Rol agregado correctamente.";
    } else {
        echo "Error al agregar el rol: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Rol</title>
</head>
<body>
    <h1>Agregar Nuevo Rol</h1>
    <form method="POST" action="roles.php">
        <label for="rol">Nombre del Rol:</label>
        <input type="text" id="rol" name="rol" required>
        <input type="submit" value="Agregar Rol">
    </form>
    <br>
    <a href="modificar_roles.php">Volver a la lista de roles</a>
</body>
</html>
