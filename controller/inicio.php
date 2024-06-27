<?php
require_once("../conexion/conexion.php");
session_start();

if(isset($_POST["inicio"])) {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    $encriptar = htmlentities(addslashes($_POST['password']));

    // Crear instancia de la clase Database
    $db = new Database();

    try {
        // Llamar al método conectar() para obtener la conexión PDO
        $con = $db->conectar();

        $sql = $con->prepare("SELECT * FROM usuarios WHERE documento = :documento");
        $sql->bindParam(':documento', $documento);
        $sql->execute();
        $fila = $sql->fetch();

        if($fila && password_verify($encriptar, $fila['password'])) {
            $_SESSION['documento'] = $fila['documento'];
            $_SESSION['nombre_comple'] = $fila['nombre_comple'];
            $_SESSION['correo'] = $fila['correo'];
            $_SESSION['password'] = $fila['password'];
            $_SESSION['tipo'] = $fila['rol'];

            if($_SESSION['documento'] == $fila['documento']) {
                header("Location: ../model/admin/index.php");
                exit();
            }
        } else {
            header("location: ../error.php");
            exit();
        }
    } catch(PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit();
    }
}
?>
