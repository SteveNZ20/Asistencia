<?php
// Parámetros de conexión a la base de datos
$host = "localhost"; // Servidor de base de datos (localhost si está en el mismo servidor)
$usuario = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$base_de_datos = "asistencia_prueba"; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar la conexión
// if ($conexion->connect_error) {
//     die("Error en la conexión: " . $conexion->connect_error);
// } else {
//     echo "Conexión exitosa a la base de datos '" . $base_de_datos . "'";
// }

// Cerrar la conexión (esto lo puedes hacer al final de tu script)
//$conexion->close();
?>