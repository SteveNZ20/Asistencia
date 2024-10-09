<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuario</title>
</head>
<body>
    <h2>Consulta de Usuario</h2>
    <form action="vista.php" method="post">
        <label for="identificador">Identificador:</label>
        <input type="text" id="identificador" name="identificador" required>
        <button type="submit">Consultar</button>
    </form>
</body>
</html>

<!-- Botón para redirigir a horarios.php -->
<br><br>
<a href="horarios.php">
    <button type="button">Marcación</button>
</a>