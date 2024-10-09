<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Verificar si se ha enviado el identificador a través de POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identificador'])) {
    $identificador = $_POST['identificador'];

    // Preparar la consulta SQL para obtener los datos del usuario
    $sql = "SELECT u.Nombres, u.Apellidos, d.DNI, d.Correo_Electronico, d.Fecha_Nacimiento, d.Ruta_Foto, d.Ruta_Documentos 
            FROM Usuarios u 
            LEFT JOIN Datos d ON u.ID = d.ID
            WHERE u.Identificador = ?";

    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("s", $identificador);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si se encontró un registro
        if ($result->num_rows > 0) {
            // Obtener los datos y mostrarlos
            $row = $result->fetch_assoc();
            
            // Mostrar la foto si está disponible
            if (!empty($row['Ruta_Foto'])) {
                $ruta_foto = "fotos/" . htmlspecialchars(basename($row['Ruta_Foto']));
                echo "<img src='" . $ruta_foto . "' alt='Foto de usuario' style='width:150px;height:auto;'><br>";
            } else {
                echo "<p>No hay foto disponible.</p>";
            }

            echo "<h2>Datos del Usuario</h2>";
            echo "Nombres: " . htmlspecialchars($row['Nombres']) . "<br>";
            echo "Apellidos: " . htmlspecialchars($row['Apellidos']) . "<br>";
            echo "DNI: " . htmlspecialchars($row['DNI']) . "<br>";
            echo "Correo Electrónico: " . htmlspecialchars($row['Correo_Electronico']) . "<br>";
            echo "Fecha de Nacimiento: " . htmlspecialchars($row['Fecha_Nacimiento']) . "<br>";

            // Mostrar el documento con la opción de descarga y vista previa
            if (!empty($row['Ruta_Documentos'])) {
                $ruta_documento = "docs/" . htmlspecialchars(basename($row['Ruta_Documentos']));
                echo "<p><a href='" . $ruta_documento . "' target='_blank'>Ver Documento</a> | ";
                echo "<a href='" . $ruta_documento . "' download>Descargar Documento</a></p>";
            } else {
                echo "<p>No hay documento disponible.</p>";
            }

        } else {
            echo "No se encontraron usuarios con el identificador: " . htmlspecialchars($identificador);
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }
} else {
    echo "Identificador no proporcionado.";
}
?>

<!-- Botón para redirigir a consulta.php -->
<br><br>
<a href="consulta.php">
    <button type="button">Volver a la Consulta</button>
</a>