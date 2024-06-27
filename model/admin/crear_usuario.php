<?php
include '../../conexion/conection.php'; // Incluye el archivo de conexión
session_start();

if (!isset($_SESSION['documento'])) {
    echo '
        <script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "index.php";
        </script>
    ';
    die();
}

$documento = $_SESSION['documento'];

try {
    // Consulta para verificar si el documento existe en la tabla usuarios
    $query = "SELECT documento FROM usuarios WHERE documento = :documento";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Crear usuario
        if (isset($_POST['crear_usuario'])) {
            $documento = $_POST['documento'];
            $nombre_comple = $_POST['nombre_comple'];
            $correo = $_POST['correo'];
            $password = $_POST['password'];

            // Validación de campos vacíos
            if (!empty($documento) && !empty($nombre_comple) && !empty($correo) && !empty($password)) {
                // Encriptación de la contraseña
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                $sql = "INSERT INTO usuarios (documento, nombre_comple, correo, password) VALUES (:documento, :nombre_comple, :correo, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':documento', $documento);
                $stmt->bindParam(':nombre_comple', $nombre_comple);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':password', $password_hash);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Usuario creado con éxito");
                            window.location = "crear_usuario.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos.");
                        window.location = "crear_usuario.php";
                    </script>
                ';
            }
        }

        // Leer usuarios
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Actualizar usuario
        if (isset($_POST['actualizar_usuario'])) {
            $documento = $_POST['documento'];
            $correo = $_POST['correo'];

            // Validación de campos vacíos
            if (!empty($documento) && !empty($correo)) {
                $sql = "UPDATE usuarios SET correo = :correo WHERE documento = :documento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':correo', $correo);
                $stmt->bindParam(':documento', $documento);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Usuario actualizado con éxito");
                            window.location = "crear_usuario.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos.");
                        window.location = "crear_usuario.php";
                    </script>
                ';
            }
        }

        // Borrar usuario
        if (isset($_POST['borrar_usuario'])) {
            $documento = $_POST['documento'];

            // Validación de campos vacíos
            if (!empty($documento)) {
                $sql = "DELETE FROM usuarios WHERE documento = :documento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':documento', $documento);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Usuario borrado con éxito");
                            window.location = "crear_usuario.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos.");
                        window.location = "crear_usuario.php";
                    </script>
                ';
            }
        }
?>
<!DOCTYPE html>
<html>
<head>
    <title>ADMINISTRADOR</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- Añade jQuery -->
    <script>
        function validateField(regex, input, errorMessage) {
            const value = input.value;
            const isValid = regex.test(value);
            input.setCustomValidity(isValid ? "" : errorMessage);
            input.reportValidity();
            return isValid;
        }

        $(document).ready(function() {
            $("#documento").on("input", function() {
                validateField(/^\d{8,10}$/, this, "Debe ingresar solo números (8 a 10 dígitos)");
            });

            $("#nombre_comple").on("input", function() {
                validateField(/^([a-zA-ZáéíóúÁÉÍÓÚ ]){3,40}$/, this, "Debe ingresar un nombre válido");
            });

            $("#correo").on("input", function() {
                validateField(/^([a-zA-Z0-9.-_@]){8,50}$/, this, "Debe ingresar un correo válido que lleve '@'");
            });

            $("#password").on("input", function() {
                validateField(/^[a-zA-Z0-9]{8}$/, this, "Debe ingresar solo números y letras (8 caracteres)");
            });
        });

        function validateForm() {
            const isDocumentoValid = validateField(/^\d{8,10}$/, document.getElementById("documento"), "Debe ingresar solo números (8 a 10 dígitos)");
            const isNombre_compleValid = validateField(/^([a-zA-ZáéíóúÁÉÍÓÚ ]){3,40}$/, document.getElementById("nombre_comple"), "Debe ingresar un nombre válido");
            const isCorreoValid = validateField(/^([a-zA-Z0-9.-_@]){8,50}$/, document.getElementById("correo"), "Debe ingresar un correo válido que lleve '@'");
            const isPasswordValid = validateField(/^[a-zA-Z0-9]{8}$/, document.getElementById("password"), "Debe ingresar solo números y letras (8 caracteres)");
        

            return isDocumentoValid  && isPasswordValid;
        }
    </script>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(89,213,201,1) 200%);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-top: -14px;
        }

        h2 {
            color: #333;
            margin-bottom: 35px;
            text-align: center; /* Centra el título */
            margin-left: 6px;
            font-family: sans-serif;
            font-weight: 600;
            font-size: 28px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.9); /* Box-shadow en todos los lados */
            width: 110%;
            max-width: 500px; /* Formulario más ancho */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px; /* Menos margen inferior */
            margin-left: -30px;
        }

        form input, form button {
            width: calc(90% - 20px);
            padding: 10px;
            margin: 5px 0; /* Menos margen entre los input */
            border-radius: 5px;
            border: 2px solid #ccc;
            font-size: 16px;
            color: black;
        }

        form button {
            background-color: #59D5C9;
            color: black;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        form button:hover {
            background-color: #45B8AA;
            transform: translateY(-3px);
        }

        table {
            width: 100%;
            max-width: 700px;
            border-collapse: collapse;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9);/* Box-shadow en todos los lados */
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: blue;
            color: #fff;
            text-align: center;
        }

        td input {
            width: calc(100% - 22px);
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        td button {
            background-color: blue;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .eliminar {
            background-color: red;
        }

        td button:hover {
            background-color: rgb(61, 61, 251);
            transform: translateY(-3px);
        }

        .eliminar:hover {
            background-color: rgb(246, 70, 70);
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            form {
                margin-bottom: 20px;
            }

            table {
                margin-left: 0;
            }
        }

    .button-container {
      width: 100%;
      display: flex;
      justify-content: flex-start; /* Alinear el botón a la izquierda */
      padding: 5px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    .button a {
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
      background-color: #59D5C9; /* Color de fondo del botón */
      color: black; /* Color del texto del botón */
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s ease, transform 0.3s ease;
      margin-top: 10px; /* Margen superior para separar del borde superior */
    }

    .button a:hover {
      background-color: #45B8AA; /* Color de fondo al pasar el cursor */
      transform: translateY(-3px); /* Animación de elevación al pasar el cursor */
    }
    </style>
</head>
<body>
<div class="button-container">
    <div class="button">
      <a href="seleccion_regis.php">Regresar</a>
    </div>
  </div>
<div class="container">
        <div>
            <h2>Crear Administrador</h2>
            <form method="post" action="">
                <input type="text" name="documento" id="documento" placeholder="Documento" required><br>
                <input type="text" name="nombre_comple" id="nombre_comple" placeholder="Nombre Completo" required><br>
                <input type="email" name="correo" id="correo" placeholder="Correo" required><br>
                <input type="password" name="password" id="password" placeholder="Contraseña" required><br>
                <button type="submit" name="crear_usuario">Crear Usuario</button>
            </form>
        </div>
      
        <div>
            <h2>Acciones</h2>
            <table>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['documento'] ?></td>
                        <form method="post" action="">
                            <td><?= $usuario['nombre_comple'] ?></td>
                            <td>
                                <input type="hidden" name="documento" value="<?= $usuario['documento'] ?>">
                                <input type="email" name="correo" id="correo" value="<?= $usuario['correo'] ?>">
                            </td>
                            <td>
                                <button type="submit" name="actualizar_usuario">Actualizar</button>
                                <button class="eliminar" type="submit" name="borrar_usuario">Borrar</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
    } else {
        echo '
            <script>
                alert("No tiene permiso para acceder a esta página");
                window.location = "../../login.php";
            </script>
        ';
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>