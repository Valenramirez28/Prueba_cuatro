<?php
include '../../conexion/conection.php'; // Incluye el archivo de conexión

try {
    $resultados_vehiculo = [];

    // Verificar si se ha pasado el parámetro documento en la URL
    if (isset($_GET['documento'])) {
        $documento = $_GET['documento'];

        // Consulta en la tabla vehiculo por documento del propietario
        $sql_vehiculo = "SELECT v.nombre, v.docu_propietario,v.numero_motor, v.numero_chasis, v.fecha_matricula, v.fecha_actual, v.capacidad, md.modelo_año, v.placa, e.estado, tv.tip_veh, l.linea_nom, c.color_nom, m.marca_nom, cl.cilindraje
        FROM vehiculo v
        JOIN estado e ON v.estado = e.id_est
        JOIN tipo_veh tv ON v.id_tip_veh = tv.id_tip_veh
        JOIN linea l ON v.linea = l.id_linea
        JOIN color c ON v.color = c.id_color
        JOIN marca m ON v.marca = m.id_marca
        JOIN cilindraje cl ON v.cilindraje_veh = cl.id_cc
        JOIN modelo md ON v.modelo = md.id_modelo
        WHERE v.docu_propietario = :documento";

        $stmt_vehiculo = $pdo->prepare($sql_vehiculo);
        $stmt_vehiculo->bindValue(':documento', $documento, PDO::PARAM_INT);
        $stmt_vehiculo->execute();
        $resultados_vehiculo = $stmt_vehiculo->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Resultados de Búsqueda por Documento</title>
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
<script type="text/javascript">
  function verpagos(id) {
    // Concatenar el parámetro placa en la URL de destino
    window.location.href = "impuesto_pago.php?id=" + id;
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
            <h2>Resultados de Búsqueda por Documento: <?= htmlspecialchars($documento) ?></h2>

            <?php if (!empty($resultados_vehiculo)) : ?>
                <table>
                    <tr>
                        <th>Nombre completo</th>
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
                        <th>Acciones</th>
                    </tr>
                    <?php foreach ($resultados_vehiculo as $vehiculo) : ?>
                        <tr>
                            <td><?= htmlspecialchars($vehiculo['nombre']) ?></td>
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
                            <td><?= htmlspecialchars($vehiculo['estado']) ?></td>
                            <td>
                            <a href="#" onclick="redireccionar('<?= htmlspecialchars($vehiculo['placa']) ?>')">Ver detalles</a>
                            <a href="#" onclick="verpagos('<?= htmlspecialchars($vehiculo['placa']) ?>')">Impuestos pagos</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No se encontraron resultados para el documento <?= htmlspecialchars($documento) ?>.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
  function redireccionar(id) {
    // Concatenar el parámetro placa en la URL de destino
    window.location.href = "detalles.php?id=" + id;
  }

  function verpagos(id) {
            window.location.href = "impuesto_pago.php?id=" + id;
        }
</script>


</html>