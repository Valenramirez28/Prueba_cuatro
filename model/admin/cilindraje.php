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
        // Leer tipos de vehículo
        $sql = "SELECT id_tip_veh, tip_veh FROM tipo_veh";
        $stmt = $pdo->query($sql);
        $tipos_vehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear cilindraje
        if (isset($_POST['crear_cilindraje'])) {
            $cilindraje = $_POST['cilindraje'];
            $id_tip_veh = $_POST['id_tip_veh'];

            // Validación de campos vacíos y cilindraje no negativo
            if (!empty($cilindraje) && !empty($id_tip_veh) && $cilindraje >= 0) {
                $sql = "INSERT INTO cilindraje (cilindraje, id_tip_veh) VALUES (:cilindraje, :id_tip_veh)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cilindraje', $cilindraje);
                $stmt->bindParam(':id_tip_veh', $id_tip_veh);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Cilindraje creado con éxito");
                            window.location = "cilindraje.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos correctamente.");
                        window.location = "cilindraje.php";
                    </script>
                ';
            }
        }

        // Leer cilindrajes
        $sql = "SELECT c.id_cc, c.cilindraje, c.id_tip_veh, t.tip_veh FROM cilindraje c LEFT JOIN tipo_veh t ON c.id_tip_veh = t.id_tip_veh";
        $stmt = $pdo->query($sql);
        $cilindrajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Actualizar cilindraje
        if (isset($_POST['actualizar_cilindraje'])) {
            $id_cc = $_POST['id_cc'];
            $cilindraje = $_POST['cilindraje'];
            $id_tip_veh = $_POST['id_tip_veh'];

            // Validación de campos vacíos y cilindraje no negativo
            if (!empty($cilindraje) && !empty($id_tip_veh) && $cilindraje >= 0) {
                $sql = "UPDATE cilindraje SET cilindraje = :cilindraje, id_tip_veh = :id_tip_veh WHERE id_cc = :id_cc";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cilindraje', $cilindraje);
                $stmt->bindParam(':id_tip_veh', $id_tip_veh);
                $stmt->bindParam(':id_cc', $id_cc);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Cilindraje actualizado con éxito");
                            window.location = "cilindraje.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos correctamente.");
                        window.location = "cilindraje.php";
                    </script>
                ';
            }
        }

        // Borrar cilindraje
        if (isset($_POST['borrar_cilindraje'])) {
            $id_cc = $_POST['id_cc'];

            // Validación de campos vacíos
            if (!empty($id_cc)) {
                $sql = "DELETE FROM cilindraje WHERE id_cc = :id_cc";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_cc', $id_cc);
                if ($stmt->execute()) {
                    echo '
                        <script>
                            alert("Cilindraje borrado con éxito");
                            window.location = "crud_cilindraje.php";
                        </script>
                    ';
                }
            } else {
                echo '
                    <script>
                        alert("Por favor, llene todos los campos.");
                        window.location = "crud_cilindraje.php";
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
 
                $("#cilindraje").on("input", function() {
                    validateField(/^([cCLl0-9,. ]){3,6}$/, this, "Debe ingresar un Cilindraje válido");
                });

            });

            function validateForm() {
                const isCilindrajeValid = validateField(/^([cCLl0-9,. ]){3,6}$/, document.getElementById("cilindraje"), "Debe ingresar un Cilindraje válido");
            

                return isCilindrajeValid;
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
            margin-bottom: 40px;
            text-align: center; /* Centra el título */
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9);
            margin-bottom: 20px;
        }

        input[type="text"], select, button {
            width: 92%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }

        button {
            background-color: blue;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: rgb(61, 61, 251);
            transform: translateY(-3px);
        }

        table {
            width: 100%;
            max-width: 700px;
            border-collapse: collapse;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9)
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

        td select {
            width: 100%;
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
            margin-bottom: 10px;
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
        <h2>Crear Cilindraje</h2>
        <form method="post" action="">
            <input type="text" name="cilindraje" id="cilindraje" placeholder="Cilindraje" min="0" required><br>
            <select name="id_tip_veh" required>
                <option value="">Seleccione el tipo de vehículo</option>
                <?php foreach ($tipos_vehiculo as $tipo): ?>
                    <option value="<?= $tipo['id_tip_veh'] ?>"><?= $tipo['tip_veh'] ?></option>
                <?php endforeach; ?>
            </select><br>
            <button type="submit" name="crear_cilindraje">Crear Cilindraje</button>
        </form>
    </div>

    <div>
        <h2>Acciones</h2>
        <table>
            <tr>
                <th>Cilindraje</th>
                <th>Tipo Vehículo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($cilindrajes as $cilindraje): ?>
                <tr>
                    <form method="post" action="">
                        <td><input type="text" name="cilindraje" id="cilindraje" value="<?= $cilindraje['cilindraje'] ?>" min="0"></td>
                        <td>
                            <select name="id_tip_veh">
                                <?php foreach ($tipos_vehiculo as $tipo): ?>
                                    <option value="<?= $tipo['id_tip_veh'] ?>" <?= $tipo['id_tip_veh'] == $cilindraje['id_tip_veh'] ? 'selected' : '' ?>><?= $tipo['tip_veh'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="id_cc" value="<?= $cilindraje['id_cc'] ?>">
                            <button type="submit" name="actualizar_cilindraje">Actualizar</button>
                            <button class="eliminar" type="submit" name="borrar_cilindraje">Borrar</button>
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