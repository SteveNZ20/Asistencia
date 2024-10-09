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
</html>