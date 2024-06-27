<?php
include '../../conexion/conection.php'; // Incluye el archivo de conexión
session_start();

if (!isset($_SESSION['documento'])) {
    echo '
        <script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "login.php";
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
        // Función para calcular el total
        function calcularTotal($valor, $porcentaje, $valor_imp)
        {
            return $valor + ($valor * $porcentaje / 100) + $valor_imp;
        }

        $sql = "SELECT impuesto.*, modelo.modelo_año, tipo_veh.tip_veh 
                FROM impuesto 
                INNER JOIN modelo ON impuesto.id_modelo = modelo.id_modelo 
                INNER JOIN tipo_veh ON impuesto.id_tip_veh = tipo_veh.id_tip_veh";
        $stmt = $pdo->query($sql);
        $impuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['crear_impuesto'])) {
            // Recibir datos del formulario
            $id_tip_veh = $_POST['id_tip_veh'];
            $id_modelo = $_POST['id_modelo'];
            $id_tip_veh = $_POST['id_tip_veh'];
            $valor_imp = $_POST['valor_imp'];
            $valor = $_POST['valor'];
            $porcentaje = $_POST['porcentaje'];
            $total_impuestos = calcularTotal($valor, $porcentaje, $valor_imp);

            // Insertar datos en la tabla impuesto
            $sql = "INSERT INTO impuesto (id_tip_veh, id_modelo, valor_imp, valor, porcentaje, total_impuestos) VALUES (:id_tip_veh, :id_modelo, :valor_imp, :valor, :porcentaje, :total_impuestos)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_tip_veh', $id_tip_veh);
            $stmt->bindParam(':id_modelo', $id_modelo);
            $stmt->bindParam(':valor_imp', $valor_imp);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':porcentaje', $porcentaje);
            $stmt->bindParam(':total_impuestos', $total_impuestos); // Insertamos el total en la tabla
            if ($stmt->execute()) {
                echo '
            <script>
                alert("Impuesto creado con éxito");
                window.location = "impuestos.php";
            </script>
        ';
            }
        } elseif (isset($_POST['accion'])) {
            if ($_POST['accion'] === 'actualizar') {
                $id_impuesto = $_POST['id_impuesto'];
                $valor_imp = $_POST['valor_imp'];
                $valor = $_POST['valor'];
                $porcentaje = $_POST['porcentaje'];
                $total_impuestos = calcularTotal($valor, $porcentaje, $valor_imp);

          // Actualizar datos en la tabla impuesto
                $sql = "UPDATE impuesto SET valor_imp = :valor_imp, valor = :valor, porcentaje = :porcentaje, total_impuestos = :total_impuestos WHERE id_impuesto = :id_impuesto";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':valor_imp', $valor_imp);
                $stmt->bindParam(':valor', $valor);
                $stmt->bindParam(':porcentaje', $porcentaje);
                $stmt->bindParam(':total_impuestos', $total_impuestos); // Insertamos el total en la tabla
                $stmt->bindParam(':id_impuesto', $id_impuesto);
                if ($stmt->execute()) {
                    echo '
                <script>
                    alert("Impuesto actualizado con éxito");
                    window.location = "impuestos.php";
                </script>
            ';

            
                }
                
            } elseif ($_POST['accion'] === 'borrar') {
                // Recibir el ID del impuesto a borrar
                $id_impuesto = $_POST['id_impuesto'];

                // Eliminar el impuesto de la base de datos
                $sql = "DELETE FROM impuesto WHERE id_impuesto = :id_impuesto";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id_impuesto', $id_impuesto);
                if ($stmt->execute()) {
                    echo '
                <script>
                    alert("Impuesto eliminado con éxito");
                    window.location = "impuestos.php";
                </script>
            ';
                }
            }
        }

        // Calcular el número total de páginas
        $sql_count = "SELECT COUNT(*) AS total FROM impuesto";
        $stmt_count = $pdo->query($sql_count);
        $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
        $total_impuestos = $row_count['total'];
        $impuestos_por_pagina = 6; // Cambia esto según la cantidad de impuestos que quieras mostrar por página
        $total_pages = ceil($total_impuestos / $impuestos_por_pagina);

        // Obtener la página actual
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $total_pages) {
            $page = $total_pages;
        }

        // Calcular el offset para la consulta SQL
        $offset = ($page - 1) * $impuestos_por_pagina;

        // Consulta SQL para obtener los impuestos de esta página
        $sql = "SELECT impuesto.*, modelo.modelo_año, tipo_veh.tip_veh 
                FROM impuesto 
                INNER JOIN modelo ON impuesto.id_modelo = modelo.id_modelo 
                INNER JOIN tipo_veh ON impuesto.id_tip_veh = tipo_veh.id_tip_veh
                LIMIT $impuestos_por_pagina OFFSET $offset";
        $stmt = $pdo->query($sql);
        $impuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
        <!DOCTYPE html>
        <html>

        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(89, 213, 201, 1) 200%);
                    margin: 0;
                    padding: 0;
                }

                .inpu {
                    color: #333;
                    text-align: center;
                    margin-top: -68px;
                    font-family: sans-serif;
                    font-weight: 600;
                }

                @media (max-width: 768px) {
                    .inpu {
                        width: calc(100% - 20px);
                        margin-top: 70%;
                        margin-left: -42%
                    }
                }

                .container {
                    display: flex;
                    justify-content: center;
                    align-items: flex-start;
                    margin: 20px;
                }

                form {
                    background-color: #fff;
                    max-width: 500px;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.9);
                    /* Box-shadow en todos los lados */
                    margin-right: 40px;
                }

                @media (max-width: 768px) {
                    form {
                        width: calc(100% - 20px);
                        margin-left: 80%;

                    }
                }

                input[type="text"],
                button {
                    width: calc(100% - 20px);
                    padding: 8px;
                    margin: 8px 0;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }

                @media (max-width: 768px) {

                    input[type="text"],
                    button {
                        width: calc(100% - 20px);
                        width: 100%;
                    }
                }

                select {
                    width: calc(106.8% - 20px);
                    padding: 8px;
                    margin: 8px 0;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    font-size: 14px;
                }

                button {
                    background-color: rgb(61, 61, 251);
                    color: white;
                    border: none;
                    cursor: pointer;
                    margin-left: 8px;
                }

                .elim {
                    background-color: red;
                    color: white;
                    border: none;
                    cursor: pointer;
                    margin-left: 8px;
                }

                .elim:hover {
                    background-color: red;
                }

                button:hover {
                    background-color: rgb(61, 61, 256);
                }

                .readonly-input {
                    background-color: #f1f1f1;
                    pointer-events: none;
                }

                table {
                    width: 100%;
                    max-width: 1000px;
                    border-collapse: collapse;
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.9);
                }

                @media (max-width: 768px) {
                    table {
                        width: calc(49% - 10px);
                        margin-top: 7%;
                        margin-left: -34%;
                    }
                }

                th,
                td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    text-align: left;
                    transition: background-color 0.3s ease;
                }

                th {
                    background-color: #f2f2f2;
                }

                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                tr:hover {
                    background-color: #f1f1f1;
                }

                .pagination {
                    text-align: center;
                    margin: 20px 0;
                }

                .pagination a {
                    margin: 0 5px;
                    padding: 10px 15px;
                    text-decoration: none;
                    color: #333;
                    border: 1px solid black;
                    border-radius: 4px;
                }

                .pagination a.active {
                    background-color: rgb(61, 61, 251);
                    color: white;
                    border: 1px solid rgb(61, 61, 253);
                }

                .pagination a:hover {
                    background-color: rgb(61, 61, 248);
                }

                .action-buttons {
                    display: flex;
                    gap: 10px;
                }

                .action-buttons button {
                    width: auto;
                    padding: 8px 12px;
                }

                .crear {
                    margin-left: 6.5%;
                    margin-bottom: 35px;
                    font-family: sans-serif;
                    font-weight: 600;
                }

                .button-container {
                    width: 100%;
                    display: flex;
                    justify-content: flex-start;
                    /* Alinear el botón a la izquierda */
                    padding: 5px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                    margin-top: 14px;
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
            <script>
                function calcularTotal(index) {
                    var valor_imp, valor, porcentaje, total;
                    if (index !== undefined) {
                        valor_imp = parseFloat(document.getElementById("valor_imp" + index).value);
                        valor = parseFloat(document.getElementById("valor" + index).value);
                        porcentaje = parseFloat(document.getElementById("porcentaje" + index).value);
                        total = valor + (valor * (porcentaje / 100)) + valor_imp;
                        document.getElementById("total_impuestos" + index).value = total.toFixed(0);
                    } else {
                        valor_imp = parseFloat(document.getElementById("valor_imp").value);
                        valor = parseFloat(document.getElementById("valor").value);
                        porcentaje = parseFloat(document.getElementById("porcentaje").value);
                        total = valor + (valor * (porcentaje / 100)) + valor_imp;
                        document.getElementById("total_impuestos").value = total.toFixed(0);
                    }
                }
            </script>
        </head>

        <body>
            <div class="button-container">
                <div class="button">
                    <a href="seleccion_regis.php">Regresar</a>
                </div>
            </div>
            <h2 class="crear">Crear Impuesto</h2>
            <div class="container">
                <form method="post" action="">
                    <select name="id_tip_veh" required>
                        <option value="">Seleccionar Tipo de Vehículo</option>
                        <?php
                        $sql_tip_veh = "SELECT * FROM tipo_veh";
                        $stmt_tip_veh = $pdo->query($sql_tip_veh);
                        while ($row_tip_veh = $stmt_tip_veh->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row_tip_veh['id_tip_veh'] . '">' . $row_tip_veh['tip_veh'] . '</option>';
                        }
                        ?>
                    </select><br>
                    <select name="id_modelo" required>
                        <option value="">Seleccionar Modelo</option>
                        <?php
                        $sql_modelo = "SELECT * FROM modelo";
                        $stmt_modelo = $pdo->query($sql_modelo);
                        while ($row_modelo = $stmt_modelo->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row_modelo['id_modelo'] . '">' . $row_modelo['modelo_año'] . '</option>';
                        }
                        ?>
                    </select><br>
                    <input type="text" id="valor_imp" name="valor_imp" placeholder="Valor impuesto" oninput="calcularTotal()" required><br>
                    <input type="text" id="valor" name="valor" placeholder="Valor del vehículo" oninput="calcularTotal()" required><br>
                    <input type="text" id="porcentaje" name="porcentaje" placeholder="Porcentaje" oninput="calcularTotal()" required><br>
                    <input type="text" id="total_impuestos" name="total_impuestos" placeholder="Total Impuesto" readonly><br>
                    <button type="submit" name="crear_impuesto">Crear Impuesto</button>

                </form>

                <div>
                    <h2 class="inpu">Impuestos</h2>
                    <table>
                        <tr>
                            <th>Tipo de Vehículo</th>
                            <th>Modelo</th>
                            <th>Valor impuesto</th>
                            <th>Valor vehiculo</th>
                            <th>Porcentaje</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($impuestos as $index => $impuesto) : ?>
                            <tr>
                                <form method="post" action="">
                            <tr>
                                <td><?= $impuesto['tip_veh'] ?></td>
                                <td><?= $impuesto['modelo_año'] ?></td>
                                <td><input type="text" name="valor_imp" id="valor_imp<?= $index ?>" placeholder="Valor impuesto" oninput="calcularTotal(<?= $index ?>)" value="<?= $impuesto['valor_imp'] ?>"></td>
                                <td><input type="text" name="valor" id="valor<?= $index ?>" value="<?= $impuesto['valor'] ?>" required oninput="calcularTotal(<?= $index ?>)"></td>
                                <td><input type="text" name="porcentaje" id="porcentaje<?= $index ?>" value="<?= $impuesto['porcentaje'] ?>" oninput="calcularTotal(<?= $index ?>)"></td>
                                <td><input type="text" name="total_impuestos" id="total_impuestos<?= $index ?>" value="<?= $impuesto['total_impuestos'] ?>" class="readonly-input" readonly></td>
                                <td class="action-buttons">
                                    <input type="hidden" name="id_impuesto" value="<?= $impuesto['id_impuesto'] ?>">
                                    <input type="hidden" name="accion" id="accion<?= $index ?>" value="actualizar">
                                    <button type="submit">Actualizar</button>
                                    <button type="button" class="elim" onclick="document.getElementById('accion<?= $index ?>').value='borrar';this.form.submit();">Borrar</button>
                                </td>
                            </tr>
                            </form>



                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <div class="pagination">
                        <?php if ($page > 1) : ?>
                            <a href="?page=<?= ($page - 1) ?>">Anterior</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <a href="?page=<?= $i ?>" <?= ($page == $i) ? 'class="active"' : '' ?>><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($page < $total_pages) : ?>
                            <a href="?page=<?= ($page + 1) ?>">Siguiente</a>
                        <?php endif; ?>
                    </div>
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
