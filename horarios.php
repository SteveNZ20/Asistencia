<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Horarios</title>
    <?php
    // Añadir meta refresh solo si se ha registrado un ingreso o salida
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificador'])) {
        echo '<meta http-equiv="refresh" content="5;url=horarios.php">'; // Refrescar cada 5 segundos
    }
    ?>
</head>
<body>
    <!-- Formulario para ingresar el identificador -->
    <form action="horarios.php" method="post">
        <label for="identificador">Identificador:</label>
        <input type="text" id="identificador" name="identificador" required>
        <button type="submit">Registrar</button>
    </form>

    <?php
    // Incluir el archivo de conexión
    include 'conexion.php';

    date_default_timezone_set('America/Lima'); // Establecer zona horaria

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificador'])) {
        $identificador = $_POST['identificador'];
        
        // Obtener la fecha actual
        $fecha_actual = date('Y-m-d');
        // Obtener la hora actual en formato 24 horas
        $hora_actual = date('H:i:s');
        
        // Verificar si el usuario existe en la tabla Usuarios
        $sql_usuario = "SELECT ID, Nombres, Apellidos FROM Usuarios WHERE Identificador = ?";
        
        if ($stmt_usuario = $conexion->prepare($sql_usuario)) {
            $stmt_usuario->bind_param("s", $identificador);
            $stmt_usuario->execute();
            $result_usuario = $stmt_usuario->get_result();
            
            if ($result_usuario->num_rows > 0) {
                // Obtener los datos del usuario
                $usuario = $result_usuario->fetch_assoc();
                $usuario_id = $usuario['ID'];
                $nombres = $usuario['Nombres'];
                $apellidos = $usuario['Apellidos'];
                
                // Verificar si ya tiene un registro de ingreso en el día actual
                $sql_horarios = "SELECT Hora_Ingreso, Hora_Salida FROM Horarios WHERE UsuarioID = ? AND Fecha = ?";
                $stmt_horarios = $conexion->prepare($sql_horarios);
                $stmt_horarios->bind_param("is", $usuario_id, $fecha_actual);
                $stmt_horarios->execute();
                $result_horarios = $stmt_horarios->get_result();
                
                if ($result_horarios->num_rows > 0) {
                    // Si ya existe un registro de ingreso, actualizar con la hora de salida
                    $horarios = $result_horarios->fetch_assoc();
                    
                    if (empty($horarios['Hora_Salida'])) {
                        $sql_actualizar_salida = "UPDATE Horarios SET Hora_Salida = ? WHERE UsuarioID = ? AND Fecha = ?";
                        $stmt_salida = $conexion->prepare($sql_actualizar_salida);
                        $stmt_salida->bind_param("sis", $hora_actual, $usuario_id, $fecha_actual);
                        $stmt_salida->execute();
                        
                        echo "<p>$nombres $apellidos</p>";
                        echo "<p>$hora_actual</p>";
                    } else {
                        echo "<p>Ya se ha registrado la hora de salida para hoy.</p>";
                    }
                } else {
                    // Si no existe un registro para hoy, registrar la hora de ingreso
                    $sql_ingreso = "INSERT INTO Horarios (UsuarioID, Fecha, Hora_Ingreso) VALUES (?, ?, ?)";
                    $stmt_ingreso = $conexion->prepare($sql_ingreso);
                    $stmt_ingreso->bind_param("iss", $usuario_id, $fecha_actual, $hora_actual);
                    $stmt_ingreso->execute();
                    
                    echo "<p>$nombres $apellidos</p>";
                    echo "<p>$hora_actual</p>";
                }
                
                $stmt_horarios->close();
            } else {
                echo "<p>No se encontró ningún usuario con el identificador: $identificador</p>";
            }
            
            $stmt_usuario->close();
        } else {
            echo "<p>Error al preparar la consulta: " . $conexion->error . "</p>";
        }
    }
    ?>
</body>
</html>
