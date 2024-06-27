<?php
// Incluir el archivo de conexión
require_once '../../conexion/conection.php';

// Verificar si el parámetro 'id' está presente y no está vacío
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtener el valor del parámetro 'id' (ya que PDO no necesita escapar)
    $id = $_GET['id'];
    
    try {
        // Consulta para obtener los datos del vehículo principal
        $sql_vehiculo = "SELECT v.nombre, v.docu_propietario, v.numero_motor, v.numero_chasis, v.fecha_matricula, v.fecha_actual, v.capacidad, md.modelo_año, v.placa, e.estado, tv.tip_veh, l.linea_nom, c.color_nom, m.marca_nom, cl.cilindraje
                        FROM vehiculo v
                        JOIN estado e ON v.estado = e.id_est
                        JOIN tipo_veh tv ON v.id_tip_veh = tv.id_tip_veh
                        JOIN linea l ON v.linea = l.id_linea
                        JOIN color c ON v.color = c.id_color
                        JOIN marca m ON v.marca = m.id_marca
                        JOIN cilindraje cl ON v.cilindraje_veh = cl.id_cc
                        JOIN modelo md ON v.modelo = md.id_modelo
                        WHERE v.placa = :id";

        $stmt_vehiculo = $pdo->prepare($sql_vehiculo);
        $stmt_vehiculo->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt_vehiculo->execute();
        $resultados_vehiculo = $stmt_vehiculo->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron resultados para el vehículo principal
        if ($resultados_vehiculo) {
            // Mostrar los datos del vehículo principal
            echo "<h2>Datos del Vehículo Principal</h2>";
            echo "<table border='1'>
                    <tr><th>Nombre</th><td>" . $resultados_vehiculo['nombre'] . "</td></tr>
                    <tr><th>Documento Propietario</th><td>" . $resultados_vehiculo['docu_propietario'] . "</td></tr>
                    <tr><th>Número de Motor</th><td>" . $resultados_vehiculo['numero_motor'] . "</td></tr>
                    <tr><th>Número de Chasis</th><td>" . $resultados_vehiculo['numero_chasis'] . "</td></tr>
                    <tr><th>Fecha de Matrícula</th><td>" . $resultados_vehiculo['fecha_matricula'] . "</td></tr>
                    <tr><th>Fecha Actual</th><td>" . $resultados_vehiculo['fecha_actual'] . "</td></tr>
                    <tr><th>Capacidad</th><td>" . $resultados_vehiculo['capacidad'] . "</td></tr>
                    <tr><th>Modelo y Año</th><td>" . $resultados_vehiculo['modelo_año'] . "</td></tr>
                    <tr><th>Placa</th><td>" . $resultados_vehiculo['placa'] . "</td></tr>
                    <tr><th>Estado</th><td>" . $resultados_vehiculo['estado'] . "</td></tr>
                    <tr><th>Tipo de Vehículo</th><td>" . $resultados_vehiculo['tip_veh'] . "</td></tr>
                    <tr><th>Línea</th><td>" . $resultados_vehiculo['linea_nom'] . "</td></tr>
                    <tr><th>Color</th><td>" . $resultados_vehiculo['color_nom'] . "</td></tr>
                    <tr><th>Marca</th><td>" . $resultados_vehiculo['marca_nom'] . "</td></tr>
                    <tr><th>Cilindraje</th><td>" . $resultados_vehiculo['cilindraje'] . "</td></tr>
                </table>";

            // Consulta para obtener los vehículos anuales asociados
            $sql_vehiculos_anuales = "SELECT va.id, va.vehiculo_id, va.anio, va.fecha_registro, i.valor, i.valor_imp, i.porcentaje, va.valor_total
                                    FROM vehiculo_anual va
                                    JOIN vehiculo v ON va.vehiculo_id = v.placa
                                    JOIN impuesto i ON v.id_tip_veh = i.id_tip_veh AND v.modelo = i.id_modelo
                                    WHERE va.estado = 2 AND va.vehiculo_id = :id";

            $stmt_anual = $pdo->prepare($sql_vehiculos_anuales);
            $stmt_anual->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_anual->execute();

            // Verificar si se encontraron resultados para los vehículos anuales
            if ($stmt_anual->rowCount() > 0) {
                // Mostrar los datos en una tabla HTML
                echo "<h2>Vehículos Anuales</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>ID Vehículo</th>
                            <th>Año</th>
                            <th>Fecha de Registro</th>
                            <th>Avaluo</th>
                            <th>Valor Impuesto</th>
                            <th>Porcentaje</th>
                            <th>Valor Total</th>
                            th>Accion</th>

                        </tr>";

                // Imprimir cada fila de datos
                while ($row = $stmt_anual->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["vehiculo_id"] . "</td>";
                    echo "<td>" . $row["anio"] . "</td>";
                    echo "<td>" . $row["fecha_registro"] . "</td>";
                    echo "<td>" . $row["valor"] . "</td>";
                    echo "<td>" . $row["valor_imp"] . "</td>";
                    echo "<td>" . $row["porcentaje"] . "</td>";
                    echo "<td>" . $row["valor_total"] . "</td>";
                    echo "<td><a href='actualizar_estado.php?id=" . $row['id'] . "' class='button'>Pagar</a></td>
";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron vehículos anuales asociados.</p>";
            }
        } else {
            echo "<p>No se encontraron datos del vehículo principal para la placa proporcionada.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "<p>Placa no especificada o inválida.</p>";
}
?>
