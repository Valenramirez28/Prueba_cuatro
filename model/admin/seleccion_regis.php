<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Cards</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap">
  <style>
    /* Estilos generales */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(89,213,201,1) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh; /* Altura completa de la ventana para centrar verticalmente */
    }

    .button-container {
      width: 100%;
      display: flex;
      justify-content: flex-start; /* Alinear el botón a la izquierda */
      padding: 17px;
      box-sizing: border-box;
    }

    .button a {
      text-decoration: none;
      font-family: 'Poppins', sans-serif;
      background-color: #59D5C9; /* Color de fondo del botón */
      color: white; /* Color del texto del botón */
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s ease, transform 0.3s ease;
      margin-top: 10px; /* Margen superior para separar del borde superior */
    }

    .button a:hover {
      background-color: #45B8AA; /* Color de fondo al pasar el cursor */
      transform: translateY(-3px); /* Animación de elevación al pasar el cursor */
    }

    .container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap; /* Permitir que las tarjetas se envuelvan si es necesario */
      gap: 10px; /* Espacio entre tarjetas */
      padding: 10px;
    }

    .card {
      flex: 1 1 300px; /* Flex-grow, flex-shrink, flex-basis */
      max-width: 300px; /* Ancho máximo de las tarjetas */
      margin: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4); /* Sombra alrededor de la tarjeta */
      transition: transform 0.3s ease;
      background: white;
      border-radius: 10px; /* Esquinas redondeadas */
      text-decoration: none;
      text-align: center;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      height: 350px; /* Aumentar la altura de las imágenes */
      object-fit: cover;
      border-top-left-radius: 10px; /* Esquinas redondeadas para la imagen superior */
      border-top-right-radius: 10px;
    }

    .card-content {
      padding: 20px;
    }

    .card-title {
      font-family: 'Poppins', sans-serif; /* Fuente elegante para el título */
      font-size: 20px;
      margin-bottom: 10px;
      text-decoration: none;
      font-weight: 600;
    }

    .card-title:hover {
      color: purple;
    }

    .card-description {
      font-size: 16px;
      color: black;
    }

    .card-description:hover {
      color: #667;
    }

    /* Estilos para pantallas pequeñas */
    @media screen and (max-width: 768px) {
      .card {
        flex: 1 1 100%; /* Ancho completo de la tarjeta */
      }
    }
  </style>
</head>
<body>
  <div class="button-container">
    <div class="button">
      <a href="index.php">Regresar</a>
    </div>
  </div>

  <div class="container">
    <!-- Tarjeta 1 -->
    <a href="crear_usuario.php" class="card">
      <img src="../../img/imagen2.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">REGISTRO DE ADMINISTRADORES</h2>
        <p class="card-description">Gestiona y crea cuentas de administradores para el sistema.</p>
      </div>
    </a>

    <!-- Tarjeta 2 -->
    <a href="estados.php" class="card">
      <img src="../../img/imagen7.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">REGISTRO DE ESTADOS</h2>
        <p class="card-description">Controla y actualiza los estados de los vehículos.</p>
      </div>
    </a>

    <!-- Tarjeta 3 -->
    <a href="tipo_vehiculo.php" class="card">
      <img src="../../img/imagen4.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">REGISTRO DE TIPO DE VEHICULOS</h2>
        <p class="card-description">Añade y administra diferentes tipos de vehículos en el sistema.</p>
      </div>
    </a>

    <a href="impuestos.php" class="card">
      <img src="../../img/impuestos.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">IMPUESTOS</h2>
        <p class="card-description">Administra y actualiza los impuestos de diferentes tipos de vehículos en el sistema.</p>
      </div>
    </a>
    <!-- Tarjeta 4 -->
    <a href="reg_vehiculo.php" class="card">
      <img src="../../img/imagen6.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">REGISTRO DE VEHICULOS</h2>
        <p class="card-description">Registra y lleva un seguimiento de los vehículos.</p>
      </div>
    </a>

    <a href="cilindraje.php" class="card">
      <img src="../../img/imagen4.jpg" alt="Image">
      <div class="card-content">
        <h2 class="card-title">REGISTRO DE CILINDRAJES</h2>
        <p class="card-description">Añade y administra diferentes tipos de vehículos en el sistema.</p>
      </div>
    </a>
  </div>
</body>
</html>
