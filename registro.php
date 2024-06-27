<?php
require 'conexion/conection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'formreg') {
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $id_rol = $_POST['id_rol'];

    try {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE documento = :documento");
        $stmt->execute(['documento' => $documento]);
        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('El usuario ya existe');</script>";
        } else {
            // Insertar el nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO usuarios (documento, nombre_comple, correo, password, rol) VALUES (:documento, :nombre, :email, :password, :id_rol)");
            $stmt->execute([
                'documento' => $documento,
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password,
                'id_rol' => $id_rol
            ]);
            echo "<script>alert('Registro exitoso');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error en el registro: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro usuario</title>
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="container">
        <div class="formulario">
            <h1>REGISTRO USUARIO</h1>
            <form method="post" name="form1" id="form1" enctype="multipart/form-data" autocomplete="off"> 
                <div class="form-row">
                    <input type="text" name="documento" id="documento" class="documento" pattern="[0-9]{8,11}" placeholder="Digite su Documento" title="El documento debe tener solo números de 8 a 10 dígitos" required>
                    <input type="text" name="nombre" id="nombre" pattern="[a-zA-ZÑ-ñ ]{4,30}" placeholder="Ingrese su Nombre Completo" title="El nombre debe tener solo letras" required>
                </div>
                <div class="form-row">
                    <input type="email" name="email" id="correo" pattern="[0-9a-zA-Z.@]{7,30}" placeholder="Ingrese su Correo" title="El correo debe tener mínimo 10 letras y números" required>
                    <input type="password" name="password" id="password" pattern="[0-9A-Za-z]{8}" placeholder="Ingrese la Contraseña" title="La contraseña debe tener números y letras (8)" required>
                </div>
                <div class="form-row">
                    <select name="id_rol" required>
                        <option value="1">Administrador</option>
                        <option value="2">Cliente</option>
                    </select>
                </div>
                <input type="submit" value="Registrarme">
                <input type="hidden" name="MM_insert" value="formreg">
            </form>
        </div>
    </div>
</body>
</html>
