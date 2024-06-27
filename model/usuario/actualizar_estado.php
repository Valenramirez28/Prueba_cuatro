<?php
// Incluir el archivo de conexión
require_once '../../conexion/conection.php';

// Verificar si el parámetro 'id' está presente en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Verificar si la conexión está establecida
        if ($pdo === null) {
            throw new Exception("La conexión a la base de datos no está establecida.");
        }

        // Preparar la consulta SQL para actualizar el estado del vehículo
        $sql = "UPDATE vehiculo_anual SET estado = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Verificar la preparación de la consulta
        if ($stmt === false) {
            throw new Exception('Error al preparar la consulta: ' . $pdo->errorInfo()[2]);
        }

        // Enlazar el parámetro 'id' a la consulta
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Mostrar alerta y redirigir a la página de inicio después de la actualización
            echo "<script>alert('Pago realizado'); window.location.href = 'buscar.php';</script>";
            exit(); // Asegurarse de que el script se detiene después de la redirección
        } else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->errorInfo()[2]);
        }

        // Cerrar la declaración preparada
        $stmt->closeCursor();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<script>alert('ID no especificado o inválido.'); window.location.href = '../index.php';</script>";
}

// Cerrar la conexión a la base de datos al finalizar
$pdo = null;
?>
