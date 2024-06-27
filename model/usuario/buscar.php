<?php
include '../../conexion/conection.php'; // Incluir el archivo de conexión

try {
    $resultados_vehiculo = [];
    $resultados_vehiculo_anual = [];

    if (isset($_POST['buscar'])) {
        $buscar = $_POST['buscar'];

        if (is_numeric($buscar)) {
            // Redirigir a documento.php si se busca por documento
            header("Location: documento.php?documento=$buscar");
            exit; // Asegura que se detenga la ejecución después de la redirección
        }
        // Consulta en la tabla vehiculo por placa o documento del propietario
        $sql_vehiculo = "SELECT v.nombre, v.docu_propietario, v.numero_motor, v.numero_chasis, v.fecha_matricula, v.fecha_actual, v.capacidad, md.modelo_año, v.placa, e.estado, tv.tip_veh, l.linea_nom, c.color_nom, m.marca_nom, cl.cilindraje
        FROM vehiculo v
        JOIN estado e ON v.estado = e.id_est
        JOIN tipo_veh tv ON v.id_tip_veh = tv.id_tip_veh
        JOIN linea l ON v.linea = l.id_linea
        JOIN color c ON v.color = c.id_color
        JOIN marca m ON v.marca = m.id_marca
        JOIN cilindraje cl ON v.cilindraje_veh = cl.id_cc
        JOIN modelo md ON v.modelo = md.id_modelo
        WHERE v.docu_propietario = :documento OR v.placa = :placa";

        $stmt_vehiculo = $pdo->prepare($sql_vehiculo);
        $stmt_vehiculo->bindValue(':documento', $buscar, PDO::PARAM_INT);
        $stmt_vehiculo->bindValue(':placa', $buscar, PDO::PARAM_STR);
        $stmt_vehiculo->execute();
        $resultados_vehiculo = $stmt_vehiculo->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($resultados_vehiculo)) {
            // Extraer las placas de los vehículos encontrados para la consulta posterior
            $placas_vehiculo = array_column($resultados_vehiculo, 'placa');

            // Consulta en la tabla vehiculo_anual por las placas obtenidas
            $sql_vehiculo_anual = "SELECT * FROM vehiculo_anual WHERE vehiculo_id IN (" . implode(',', array_fill(0, count($placas_vehiculo), '?')) . ")";
            $stmt_vehiculo_anual = $pdo->prepare($sql_vehiculo_anual);
            $stmt_vehiculo_anual->execute($placas_vehiculo);
            $resultados_vehiculo_anual = $stmt_vehiculo_anual->fetchAll(PDO::FETCH_ASSOC);

            // Verificar si todos los estados de vehiculo_anual están en 1
            $todosEstadoUno = true;
            foreach ($resultados_vehiculo_anual as $vehiculo_anual) {
                if ($vehiculo_anual['estado'] != 1) {
                    $todosEstadoUno = false;
                    break;
                }
            }

            // Si todos los estados están en 1, actualizar estado en vehiculo
            if ($todosEstadoUno) {
                $sql_update_estado = "UPDATE vehiculo SET estado = 1 WHERE placa IN (" . implode(',', array_fill(0, count($placas_vehiculo), '?')) . ")";
                $stmt_update_estado = $pdo->prepare($sql_update_estado);
                $stmt_update_estado->execute($placas_vehiculo);
                $numFilasActualizadas = $stmt_update_estado->rowCount();
            }
        }
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Resultados de Búsqueda</title>
    <!-- Estilos -->
    <style>
        /* Estilos generales */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(89, 213, 201, 1) 200%);
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
            text-align: center;
            /* Centra el título */
            margin-left: 6px;
            font-family: sans-serif;
            font-weight: 600;
            font-size: 28px;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.9);
            /* Box-shadow en todos los lados */
            width: 110%;
            max-width: 500px;
            /* Formulario más ancho */
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
            /* Menos margen inferior */
            margin-left: -30px;
        }

        form input,
        form button {
            width: calc(90% - 20px);
            padding: 10px;
            margin: 5px 0;
            /* Menos margen entre los input */
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
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.9);
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
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
            justify-content: flex-start;
            /* Alinear el botón a la izquierda */
            padding: 5px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        .button a {
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            background-color: #59D5C9;
            /* Color de fondo del botón */
            color: black;
            /* Color del texto del botón */
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
            /* Margen superior para separar del borde superior */
        }

        .button a:hover {
            background-color: #45B8AA;
            /* Color de fondo al pasar el cursor */
            transform: translateY(-3px);
            /* Animación de elevación al pasar el cursor */
        }
    </style>
</head>
<script>
    function confirmarPago(id) {
        if (confirm("¿Estás seguro de que quieres marcar este vehículo como pagado?")) {
            pagar(placa);
        }
    }

    function pagar(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "actualizar_estado.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
                // Aquí puedes añadir lógica para actualizar la interfaz según sea necesario
                location.reload(); // Recargar la página para reflejar los cambios
            }
        };
        xhr.send("id=" + id);
    }
</script>

<body>
    <div class="button-container">
        <div class="button">
            <a href="../../index.php">Regresar</a>
        </div>
    </div>
    <div class="container">

        <div>
            <h2>Resultados de Búsqueda</h2>

            <?php if (!empty($resultados_vehiculo)) : ?>
                <h3>Resultados de la busqueda:</h3>
                <table>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Documento Propietario</th>
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
                        <th>Fecha Actual</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                    </tr>
                    <?php foreach ($resultados_vehiculo as $vehiculo) : ?>
                        <tr>
                            <td><?= htmlspecialchars($vehiculo['nombre']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['docu_propietario']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['tip_veh']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['cilindraje']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['modelo_año']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['placa']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['marca_nom']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['linea_nom']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['color_nom']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['numero_motor']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['numero_chasis']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['fecha_matricula']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['fecha_actual']) ?></td>
                            <td><?= htmlspecialchars($vehiculo['capacidad']) ?></td>
                            <td>
                                <?php if ($vehiculo['estado'] == 2) : ?>
                                    <a class="btn btn-danger" href="#" onclick="redireccionar('<?= htmlspecialchars($vehiculo['placa']) ?>')">En deuda</a>
                                <?php elseif ($vehiculo['estado'] == 1) : ?>
                                    <span>Pago</span>
                                <?php else : ?>
                                    <span><?= htmlspecialchars($vehiculo['estado']) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No se encontraron resultados en los registros de Vehículos.</p>
            <?php endif; ?>

            <?php if (!empty($resultados_vehiculo_anual)) : ?>
                <h3>Detalles:</h3>
                <table>
                    <tr>
                        <th>Vehículo ID</th>
                        <th>Año</th>
                        <th>Valor</th>
                        <th>Estado</th>
                        <th>Fecha de Registro</th>
                        <th>Accion</th>

                    </tr>
                    <?php foreach ($resultados_vehiculo_anual as $vehiculo_anual) : ?>
                        <tr>
                            <td><?= htmlspecialchars($vehiculo_anual['vehiculo_id']) ?></td>
                            <td><?= htmlspecialchars($vehiculo_anual['anio']) ?></td>
                            <td><?= htmlspecialchars($vehiculo_anual['valor_total']) ?></td>
                            <td>
                                <?php if ($vehiculo_anual['estado'] == 2) : ?>
                                    <span>En deuda</span>
                                <?php elseif ($vehiculo_anual['estado'] == 1) : ?>
                                    <span>Pago</span>
                                <?php else : ?>
                                    <span><?= htmlspecialchars($vehiculo_anual['estado']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($vehiculo_anual['fecha_registro']) ?></td>
                            <td>
                                <?php if ($vehiculo_anual['estado'] == 1) : ?>
                                    <span class='button' disabled>Pago
                                    </span>
                                <?php else : ?>
                                    <a href='actualizar_estado.php?id=<?= htmlspecialchars($vehiculo_anual['id']) ?>' class='button'>Pagar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No se encontraron resultados en la tabla Vehículo Anual.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
<script type="text/javascript">
    function redireccionar(placa) {
        window.location.href = "actualizar_estado.php?id=" + id;
    }
</script>

</html>