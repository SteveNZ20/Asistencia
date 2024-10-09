<?php
// Conexión a la base de datos
include 'conexion.php';

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibe los datos del formulario
    $id_usuario = $_POST['id_usuario'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Manejar la subida de la foto
    $ruta_foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $directorio_foto = '/Users/steve/Desktop/Control de Asistencia/prueba/fotos/';
        $nombre_foto = basename($_FILES['foto']['name']);
        $ruta_foto = $directorio_foto . $nombre_foto;
        
        // Mueve el archivo a la ruta designada
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_foto)) {
            echo "Error al subir la foto.";
            exit;
        }
    }

    // Manejar la subida del documento
    $ruta_documento = null;
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] == 0) {
        $directorio_documento = '/Users/steve/Desktop/Control de Asistencia/prueba/docs/';
        $nombre_documento = basename($_FILES['documento']['name']);
        $ruta_documento = $directorio_documento . $nombre_documento;

        // Mueve el archivo a la ruta designada
        if (!move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_documento)) {
            echo "Error al subir el documento.";
            exit;
        }
    }

    // Inserta los datos en la tabla Datos
    $sql = "INSERT INTO Datos (ID, DNI, Correo_Electronico, Fecha_Nacimiento, Ruta_Foto, Ruta_Documentos)
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("isssss", $id_usuario, $dni, $correo, $fecha_nacimiento, $ruta_foto, $ruta_documento);

        if ($stmt->execute()) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar los datos: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }

    $conexion->close();
}
?>

<!-- Formulario HTML para insertar datos -->
<form action="insertar_datos.php" method="POST" enctype="multipart/form-data">
    ID Usuario: <input type="number" name="id_usuario" required><br>
    DNI: <input type="text" name="dni" required><br>
    Correo Electrónico: <input type="email" name="correo" required><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" required><br>
    Foto: <input type="file" name="foto" accept="image/*"><br>
    Documento: <input type="file" name="documento" accept=".doc,.docx,.pdf"><br>
    <input type="submit" value="Insertar Datos">
</form>