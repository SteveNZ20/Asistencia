<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los arrays de datos del formulario
    $sedes = $_POST['sede'];
    $encargados_mana = $_POST['encargado_mana'];
    $encargados_tarde = $_POST['encargado_tarde'];
    $fechas_inicio = $_POST['fecha_inicio'];
    $fechas_fin = $_POST['fecha_fin'];

    // Preparar la consulta SQL para insertar en la tabla AdmSedes
    $sql = "INSERT INTO AdmSedes (SedeID, Encargado_Mañana, Encargado_Tarde, Fecha_Inicio, Fecha_Fin) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {
        // Recorrer los arrays y realizar una inserción por cada fila del formulario
        for ($i = 0; $i < count($sedes); $i++) {
            // Vincular los parámetros para cada iteración
            $stmt->bind_param("iiiss", $sedes[$i], $encargados_mana[$i], $encargados_tarde[$i], $fechas_inicio[$i], $fechas_fin[$i]);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<p>Registro de administración de sede guardado exitosamente para la sede ID: " . $sedes[$i] . ".</p>";
            } else {
                echo "<p>Error al guardar el registro: " . $conexion->error . "</p>";
            }
        }
        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "<p>Error al preparar la consulta: " . $conexion->error . "</p>";
    }
}

// Obtener las sedes para llenar la lista desplegable
$sql_sedes = "SELECT ID, Nombre_Sede FROM Sedes";
$result_sedes = $conexion->query($sql_sedes);

// Obtener los usuarios para llenar las listas de encargados
$sql_usuarios = "SELECT ID, CONCAT(Nombres, ' ', Apellidos) AS NombreCompleto FROM Usuarios";
$result_usuarios = $conexion->query($sql_usuarios);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Administración de Sedes</title>
    <script>
        function agregarFila() {
            var table = document.getElementById("tabla_admsedes");
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            row.innerHTML = `
                <td>
                    <select name="sede[]" required>
                        <?php
                        // Volver a consultar las sedes para la nueva fila
                        $result_sedes->data_seek(0); // Reiniciar el puntero del resultado
                        while ($sede = $result_sedes->fetch_assoc()) {
                            echo "<option value='" . $sede['ID'] . "'>" . htmlspecialchars($sede['Nombre_Sede']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="encargado_mana[]" required>
                        <option value="">Seleccione</option>
                        <?php
                        // Volver a consultar los usuarios para la nueva fila
                        $result_usuarios->data_seek(0); // Reiniciar el puntero del resultado
                        while ($usuario = $result_usuarios->fetch_assoc()) {
                            echo "<option value='" . $usuario['ID'] . "'>" . htmlspecialchars($usuario['NombreCompleto']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="encargado_tarde[]" required>
                        <option value="">Seleccione</option>
                        <?php
                        // Volver a consultar los usuarios para la nueva fila
                        $result_usuarios->data_seek(0); // Reiniciar el puntero del resultado
                        while ($usuario = $result_usuarios->fetch_assoc()) {
                            echo "<option value='" . $usuario['ID'] . "'>" . htmlspecialchars($usuario['NombreCompleto']) . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="date" name="fecha_inicio[]" required>
                </td>
                <td>
                    <input type="date" name="fecha_fin[]" required>
                </td>
            `;
        }
    </script>
</head>

<body>
    <h2>Registrar Administración de Sedes</h2>

    <form action="insertar_admsedes.php" method="post">
        <table id="tabla_admsedes" border="1">
            <thead>
                <tr>
                    <th>SEDE</th>
                    <th>ENCARGADO TM</th>
                    <th>ENCARGADO TT</th>
                    <th>FECHA DE INICIO</th>
                    <th>FECHA FIN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="sede[]" required>
                            <?php
                            // Reiniciar el puntero del resultado antes de generar la primera fila
                            $result_sedes->data_seek(0);
                            while ($sede = $result_sedes->fetch_assoc()) {
                                echo "<option value='" . $sede['ID'] . "'>" . htmlspecialchars($sede['Nombre_Sede']) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="encargado_mana[]" required>
                            <option value="">Seleccione</option>
                            <?php
                            // Reiniciar el puntero del resultado antes de generar la primera fila
                            $result_usuarios->data_seek(0);
                            while ($usuario = $result_usuarios->fetch_assoc()) {
                                echo "<option value='" . $usuario['ID'] . "'>" . htmlspecialchars($usuario['NombreCompleto']) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="encargado_tarde[]" required>
                            <option value="">Seleccione</option>
                            <?php
                            // Reiniciar el puntero del resultado antes de generar la primera fila
                            $result_usuarios->data_seek(0);
                            while ($usuario = $result_usuarios->fetch_assoc()) {
                                echo "<option value='" . $usuario['ID'] . "'>" . htmlspecialchars($usuario['NombreCompleto']) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" name="fecha_inicio[]" required>
                    </td>
                    <td>
                        <input type="date" name="fecha_fin[]" required>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="agregarFila()">Agregar Fila</button>
        <button type="submit">Guardar</button>
    </form>
</body>

</html>