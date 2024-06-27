<?php
include '../../conexion/conection.php';
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
    $query = "SELECT documento FROM usuarios WHERE documento = :documento";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Leer tipos de vehículo
        $sql = "SELECT id_tip_veh, tip_veh FROM tipo_veh";
        $stmt = $pdo->query($sql);
        $tipos_vehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Leer estado
        $sql = "SELECT * FROM estado";
        $stmt = $pdo->query($sql);
        $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Leer modelos
        $sql = "SELECT id_modelo, modelo_año FROM modelo";
        $stmt = $pdo->query($sql);
        $modelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Leer marcas
        $sql = "SELECT id_marca, marca_nom FROM marca";
        $stmt = $pdo->query($sql);
        $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Leer colores
        $sql = "SELECT id_color, color_nom FROM color";
        $stmt = $pdo->query($sql);
        $colores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Leer cilindrajes
        $sql = "SELECT id_cc, cilindraje FROM cilindraje";
        $stmt = $pdo->query($sql);
        $cilindraje = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT id_linea, linea_nom FROM linea";
        $stmt = $pdo->query($sql);
        $linea = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Crear vehículo
        if (isset($_POST['crear_vehiculo'])) {
            $nombre = $_POST['nombre'];
            $docu_propietario = $_POST['docu_propietario'];
            $id_tip_veh = $_POST['id_tip_veh'];
            $id_modelo = $_POST['id_modelo'];
            $id_marca = $_POST['id_marca'];
            $placa = $_POST['placa'];
            $id_linea = $_POST['id_linea'];
            $id_color = $_POST['id_color'];
            $id_cc = $_POST['id_cc'];
            $numero_motor = $_POST['numero_motor'];
            $numero_chasis = $_POST['numero_chasis'];
            $fecha_matricula = $_POST['fecha_matricula'];
            $capacidad = $_POST['capacidad'];
            $estado = 2;

            if (!empty($nombre) && !empty($docu_propietario) && !empty($id_tip_veh) && !empty($id_modelo) && !empty($placa) && !empty($id_marca) && !empty($id_linea) && !empty($id_color) && !empty($id_cc) && !empty($numero_motor) && !empty($numero_chasis) && !empty($fecha_matricula) && !empty($capacidad) && !empty($estado)) {
                // Verificar si la placa ya existe en la base de datos
                $placa_existente = $pdo->prepare("SELECT COUNT(*) FROM vehiculo WHERE placa = :placa");
                $placa_existente->bindParam(':placa', $placa);
                $placa_existente->execute();
                if ($placa_existente->fetchColumn() > 0) {
                    echo '
                        <script>
                            alert("La placa ingresada ya existe en la base de datos. Por favor, ingrese una placa diferente.");
                            window.location = "reg_vehiculo.php";
                        </script>
                    ';
                    die();
                }

                try {
                    // Iniciar una transacción
                    $pdo->beginTransaction();
                
                    // Verificar si la placa ya existe
                    $sql = "SELECT COUNT(*) FROM vehiculo WHERE placa = :placa";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':placa', $placa, PDO::PARAM_STR);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                
                    if ($count > 0) {
                        throw new Exception("El vehículo con la placa $placa ya existe.");
                    }
                
                    // Insertar el nuevo vehículo
                    $sql = "INSERT INTO vehiculo (nombre, docu_propietario, id_tip_veh, modelo, placa, marca, linea, color, cilindraje_veh, numero_motor, numero_chasis, fecha_matricula, capacidad, estado) VALUES (:nombre, :docu_propietario, :id_tip_veh, :id_modelo, :placa, :id_marca, :id_linea, :id_color, :id_cc, :numero_motor, :numero_chasis, :fecha_matricula, :capacidad, :estado)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                    $stmt->bindParam(':docu_propietario', $docu_propietario, PDO::PARAM_STR);
                    $stmt->bindParam(':id_tip_veh', $id_tip_veh, PDO::PARAM_INT);
                    $stmt->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);
                    $stmt->bindParam(':placa', $placa, PDO::PARAM_STR);
                    $stmt->bindParam(':id_marca', $id_marca, PDO::PARAM_STR);
                    $stmt->bindParam(':id_linea', $id_linea, PDO::PARAM_STR);
                    $stmt->bindParam(':id_color', $id_color, PDO::PARAM_STR);
                    $stmt->bindParam(':id_cc', $id_cc, PDO::PARAM_INT);
                    $stmt->bindParam(':numero_motor', $numero_motor, PDO::PARAM_STR);
                    $stmt->bindParam(':numero_chasis', $numero_chasis, PDO::PARAM_STR);
                    $stmt->bindParam(':fecha_matricula', $fecha_matricula, PDO::PARAM_STR);
                    $stmt->bindParam(':capacidad', $capacidad, PDO::PARAM_INT);
                    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
                
                    $stmt->execute();
                
                    // Calcular el valor total de los impuestos
                    $impuesto_base = $pdo->prepare("SELECT total_impuestos FROM impuesto WHERE id_tip_veh = :id_tip_veh AND id_modelo = :id_modelo");
                    $impuesto_base->bindParam(':id_tip_veh', $id_tip_veh, PDO::PARAM_INT);
                    $impuesto_base->bindParam(':id_modelo', $id_modelo, PDO::PARAM_INT);
                    $impuesto_base->execute();
                    $total_impuestos = $impuesto_base->fetchColumn();
                
                    if ($total_impuestos == 0) {
                        throw new Exception("No se puede crear el vehículo porque el impuesto para este auto no ha sido asignado.");
                    }
                
                    // Obtener la fecha de matrícula y la fecha actual
                    $fecha_matricula_obj = new DateTime($fecha_matricula);
                    $fecha_actual_obj = new DateTime();
                
                    // Obtener el año de la fecha de matrícula
                    $year_matricula = (int) $fecha_matricula_obj->format('Y');
                
                    // Obtener el año actual
                    $year_actual = (int) $fecha_actual_obj->format('Y');
                
                    // Iterar sobre los años desde el año de matrícula hasta el año actual
                    for ($year = $year_matricula; $year <= $year_actual; $year++) {
                        // Construir la fecha del año actual en formato Y-m-d
                        $fecha_anual = $year . $fecha_matricula_obj->format('-m-d');
                
                        // Insertar el registro en la tabla vehiculo_anual
                        $sql = "INSERT INTO vehiculo_anual (vehiculo_id, anio, valor_total, estado) VALUES (:vehiculo_id, :anio, :valor_total, :estado)";
                        $stmt_anual = $pdo->prepare($sql);
                        $stmt_anual->bindParam(':vehiculo_id', $placa, PDO::PARAM_STR);
                        $stmt_anual->bindParam(':anio', $fecha_anual, PDO::PARAM_STR);
                        $stmt_anual->bindParam(':valor_total', $total_impuestos, PDO::PARAM_INT);
                        $stmt_anual->bindParam(':estado', $estado, PDO::PARAM_INT);
                        $stmt_anual->execute();
                    }
                
                    // Confirmar la transacción
                    $pdo->commit();
                
                    echo '
                        <script>
                            alert("Vehículo creado con éxito");
                            window.location = "reg_vehiculo.php";
                        </script>
                    ';
                } catch (Exception $e) {
                    // Revertir la transacción en caso de error
                    $pdo->rollBack();
                
                    echo '
                        <script>
                            alert("Error: ' . $e->getMessage() . '");
                        </script>
                    ';
                }
                
                
            } else {
                echo '
                    <script>
                        alert("Error al crear el vehiculo.");
                        window.location = "reg_vehiculo.php";
                    </script>
                ';
            }
        }

        // Leer vehículos
        $sql = "SELECT v.*, t.tip_veh, e.estado as estado_nombre, m.modelo_año, ma.marca_nom, c.color_nom, cc.cilindraje AS cilindraje_vehiculo
        FROM vehiculo v 
        JOIN tipo_veh t ON v.id_tip_veh = t.id_tip_veh 
        JOIN estado e ON v.estado = e.id_est 
        JOIN modelo m ON v.modelo = m.id_modelo 
        JOIN marca ma ON v.marca = ma.id_marca 
        JOIN color c ON v.color = c.id_color 
        JOIN cilindraje cc ON v.cilindraje_veh = cc.id_cc";
        $stmt = $pdo->query($sql);
        $vehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Actualizar vehículo
        if (isset($_POST['actualizar_vehiculo'])) {
            $id_veh = $_POST['id_veh'];
            $fecha_actual = date("Y-m-d H:i:s");
            $valor_total = $_POST['valor_total']; // Agregar valor_total a la lista de parámetros recibidos

            $sql = "UPDATE vehiculo SET fecha_actual = :fecha_actual, valor_total = :valor_total WHERE id_veh = :id_veh";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':fecha_actual', $fecha_actual);
            $stmt->bindParam(':valor_total', $valor_total);
            $stmt->bindParam(':id_veh', $id_veh);

            if ($stmt->execute()) {
                echo '
                    <script>
                        alert("Fecha y valor total actualizados con éxito");
                        window.location = "reg_vehiculo.php";
                    </script>
                ';
            } else {
                echo '
                    <script>
                        alert("Error al actualizar la fecha y valor total");
                        window.location = "reg_vehiculo.php";
                    </script>
                ';
            }
        }

        // Eliminar vehículo
        if (isset($_POST['eliminar_vehiculo'])) {
            $placa = $_POST['placa']; // Asegúrate de obtener la placa del vehículo a eliminar
            $sql = "DELETE FROM vehiculo WHERE placa = :placa"; // Query para eliminar el vehículo
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':placa', $placa);
            if ($stmt->execute()) {
                echo '
            <script>
                alert("Vehículo eliminado con éxito");
                window.location = "reg_vehiculo.php";
            </script>
        ';
            } else {
                echo '
            <script>
                alert("Error al eliminar el vehículo");
                window.location = "reg_vehiculo.php";
            </script>
        ';
            }
        }



?>

        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Gestión de Vehículos</title>
            <link rel="stylesheet" type="text/css" href="../../css/vehiculos.css">
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
                $("#docu_propietario").on("input", function() {
                    validateField(/^\d{8,10}$/, this, "Debe ingresar solo números (8 a 10 dígitos)");
                });

                $("#placa").on("input", function() {
                    validateField(/^([a-zA-Z0-9]){5,6}$/, this, "Debe ingresar una placa válida");
                });

                $("#numero_motor").on("input", function() {
                    validateField(/^([a-zA-Z0-9]){8,17}$/, this, "El numero del motor debe contener minimo 8 caracteres máximo 17");
                });

                $("#numero_chasis").on("input", function() {
                    validateField(/^([a-zA-Z0-9]){17}$/, this, "Debe ingresar el numero de chasis de 17 caracteres alfanúmerico");
                });
                $("#capacidad").on("input", function() {
                    validateField(/^([2345]){1}$/, this, "Debe ingresar la capacidad máxima del vehiculo");
                });
            });

            function validateForm() {
                const isPlacaValid = validateField(/^([a-zA-Z0-9]){5,6}$/, document.getElementById("placa"), "Debe ingresar una placa válida");
                const isNumero_motorValid = validateField(/^([a-zA-Z0-9]){8,17}$/, document.getElementById("numero_motor"), "El numero del motor debe contener minimo 8 caracteres máximo 17");
                const isNumero_chasisValid = validateField(/^([a-zA-Z0-9.-_@]){8,50}$/, document.getElementById("numero_chasis"), "Debe ingresar el numero de chasis de 17 caracteres alfanúmerico");
                const isCapacidadValid = validateField(/^([2345]){1}$/, document.getElementById("capacidad"), "Debe ingresar la capacidad máxima del vehiculo");
            

                return isPlacaValid  && isNumero_motorValid && isNumero_chasisValid && isCapacidadValid;
            }
        </script>
        </head>
<style>
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
        <body>
        <div class="button-container">
    <div class="button">
        <a href="seleccion_regis.php">Regresar</a>
    </div>
</div>
        <div class="login-box">
            <h1>Gestión de Vehículos</h1>
            <form action="reg_vehiculo.php" method="post">
            <div class="row">
                <input type="text" name="docu_propietario" id="docu_propietario" pattern="[0-9]{8,10}" placeholder="Documento del Propietario" title="El documento debe tener de 8 a 10 dígitos" required>
                <input type="text" name="nombre" id="nombre"  placeholder="Nombre completo" required>
                <label for="id_tip_veh">Tipo de Vehículo:</label>
                <select name="id_tip_veh" id="id_tipo_veh" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($tipos_vehiculo as $tipo) : ?>
                        <option value="<?php echo $tipo['id_tip_veh']; ?>"><?php echo $tipo['tip_veh']; ?></option>
                    <?php endforeach; ?>
                </select>
                    
                    </div>
                    <div class="row-card">
                    <label>Cilindrajes </label>
                        <select name="id_cc" id="id_cc">
                            <option value="">Seleccione...</option>
                        </select>
                <!-- Dropdown for Modelo -->
                <label for="id_modelo">Modelo:</label>
                <select name="id_modelo" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($modelos as $modelo) : ?>
                        <option value="<?php echo $modelo['id_modelo']; ?>"><?php echo $modelo['modelo_año']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Dropdown for Marca -->
                <label for="id_marca">Marca:</label>
                <select name="id_marca" id="id_marca" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($marcas as $marca) : ?>
                        <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['marca_nom']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="id_marca">Linea:</label>
                <select name="id_linea" id="id_linea" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($linea as $lineas) : ?>
                        <option value="<?php echo $lineas['id_linea']; ?>"><?php echo $lineas['linea_nom']; ?></option>
                    <?php endforeach; ?>
                </select>
                    </div>
                <div class="row-input">
                <label for="id_color">Color:</label>
                <select name="id_color" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($colores as $color) : ?>
                        <option value="<?php echo $color['id_color']; ?>"><?php echo $color['color_nom']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="placa" id="placa"  placeholder="placa" required>
                <input type="text" name="numero_motor" id="numero_motor" placeholder="Número de Motor" required>
                    </div>
                    <div class="row-info">
                <input type="text" name="numero_chasis" id="numero_chasis" placeholder="Número de Chasis" required>
                <label>Fecha de matricula</label>
                <input type="date" name="fecha_matricula" placeholder="Fecha de Matrícula" required>
                <input type="text" name="capacidad" id="capacidad" placeholder="Capacidad" required><br>
                </div>

                <button type="submit" class="boton" name="crear_vehiculo">Crear Vehículo</button>
            </form>
                    </div>

            <h2>Listado de Vehículos</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th class="docu">Documento Propietario</th>
                        <th>Nombre</th>
                        <th>Tipo Vehículo</th>
                        <th>Cilindraje</th>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Línea</th>
                        <th>Color</th>
                        <th>Número Motor</th>
                        <th>Número Chasis</th>
                        <th>Fecha Matrícula</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehiculo as $veh) : ?>
                        <tr>
                            <form method="post">
                                <td class="docu"><?php echo $veh['docu_propietario']; ?></td>
                                <td class="docu"><?php echo $veh['nombre']; ?></td>
                                <td><?php echo $veh['tip_veh']; ?></td>
                                <td><?php echo $veh['cilindraje_vehiculo']; ?></td>
                                <td><?php echo $veh['modelo_año']; ?></td>
                                <td><?php echo $veh['placa']; ?></td>
                                <td><?php echo $veh['marca_nom']; ?></td>
                                <td><?php echo $veh['linea']; ?></td>
                                <td><?php echo $veh['color_nom']; ?></td>
                                <td><?php echo $veh['numero_motor']; ?></td>
                                <td><?php echo $veh['numero_chasis']; ?></td>
                                <td><?php echo $veh['fecha_matricula']; ?></td>
                                <td><?php echo $veh['capacidad']; ?></td>
                                <td>
                                    <select name="estado" required>
                                        <?php foreach ($estados as $estado) : ?>
                                            <option value="<?php echo $estado['id_est']; ?>" <?php echo $estado['id_est'] == $veh['estado'] ? 'selected' : ''; ?>><?php echo $estado['estado']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="placa" value="<?php echo $veh['placa']; ?>">
                        <button type="submit" class="eliminar" name="eliminar_vehiculo">Eliminar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('id_tipo_veh').val(0);
                recargar();
                $('#id_tipo_veh').change(function() {
                    recargar();
                });
            })
        </script>

        <script type="text/javascript">
            function recargar() {
                $.ajax({
                    type: "POST",
                    url: "dato.php",
                    data: "id_tipo_veh=" + $('#id_tipo_veh').val(),
                    success: function(r) {
                        $('#id_cc').html(r);
                    }
                });
            }
        </script>
 
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