<?php
session_start();

include("../../conexion/conection.php");

if (!isset($_SESSION['documento'])) {
    echo '
        <script>
            alert("Por favor inicie sesión e intente nuevamente");
            window.location = "../../login.php";
        </script>
    ';
    exit();
}

$documento = $_SESSION['documento'];

try {
    // Consulta para verificar si el documento existe en la tabla usuarios
    $query = "SELECT documento FROM usuarios WHERE documento = :documento";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Interfaz Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemos.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
    <style>
        .carousel-item {
            margin-top: 0px;
            height: 84vh; /* Adjust this value as needed */
            min-height: 300px;
            width: 90%;
            margin-left: 70px;
        }

        .carousel-inner img {
            object-fit: cover;
            width: 90%;
            height: 100%;
        }

        .navbar {
            margin-bottom: 30px; /* Add space between the navbar and the carousel */
        }

        

        .logout-btn {
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
            background-color: aqua;
            border-radius: 10px;
            font-weight: 600;
            width: auto;
            color: black;
            margin-left: 20px;
            margin-right: 30px;
        }

        .logout-btn:hover {
            transform: scale(1.1);
            color: black;
        }


    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="nav-item">
    <a class="nav-link logout-btn" id="logoutBtn" href="cerrar.php">Cerrar sesión</a>
    </div>
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-success logo h2 align-self-center" href="index.php">
                ADMINISTRADOR
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
                <div class="flex-fill">
                    <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="seleccion_regis.php">Registros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tipo_vehiculo.php">impuestos pagos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tipo_vehiculo.php">impuestos no pagos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Start Banner Hero -->
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/img/imagen1.jpg" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="./assets/img/imagen2.jpg" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="./assets/img/imagen3.jpg" class="d-block w-100" alt="Imagen 3">
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <!-- End Banner Hero -->

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->
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

