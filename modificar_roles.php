<?php
// Incluir archivo de conexión
include('conexion.php');

// Eliminar rol y reiniciar AUTO_INCREMENT
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM Roles WHERE ID = $id";
    if (mysqli_query($conexion, $sql)) {
        // Reiniciar el AUTO_INCREMENT
        $sql_reset_ai = "ALTER TABLE Roles AUTO_INCREMENT = 1";
        mysqli_query($conexion, $sql_reset_ai);
        echo "Rol eliminado correctamente.";
    } else {
        echo "Error al eliminar el rol: " . mysqli_error($conexion);
    }
}

// Actualizar rol
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nuevo_rol = $_POST['rol'];

    $sql = "UPDATE Roles SET Rol = '$nuevo_rol' WHERE ID = $id";
    if (mysqli_query($conexion, $sql)) {
        echo "Rol actualizado correctamente.";
    } else {
        echo "Error al actualizar el rol: " . mysqli_error($conexion);
    }
}

// Obtener lista de roles
$sql = "SELECT * FROM Roles";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Roles</title>
</head>
<body>
    <h1>Lista de Roles</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['Rol']; ?></td>
            <td>
                <form method="POST" style="display:inline-block;" action="modificar_roles.php">
                    <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                    <input type="text" name="rol" value="<?php echo $row['Rol']; ?>" required>
                    <input type="submit" name="editar" value="Editar">
                </form>
                <a href="modificar_roles.php?eliminar=<?php echo $row['ID']; ?>" onclick="return confirm('¿Estás seguro de eliminar este rol?');">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="roles.php">Agregar Nuevo Rol</a>
</body>
</html>
