<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Inicio de Sesión</title>
  <link rel="stylesheet" type="text/css" href="css/error.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

  <div class="container">
    <div class="formulario">
      <h1>ERROR AL INICIAR SESIÓN</h1>
      <form method="POST" name="form1" id="form1" action="controller/inicio.php" autocomplete="off">
        <label for="documento"> Documento:</label>
        <div class="input-contenedor">
        <i class="fas fa-user"></i>
        <input type="text" name="documento" id="documento" pattern="[0-9]{8,10}" placeholder="Ingrese su Documento" title="El documento debe tener solo numeros, de 8 a 10 digitos">
        </div>
        <label for="password">Contraseña:</label>
        <div class="password-container">
            <div class="input-contenedor">
            <i class="far fa-eye" id="togglePassword"></i>
          <input type="password" name="password" id="password" pattern="[A-Za-z0-9]{8}" placeholder="Ingrese la contraseña" title="La contraseña debe tener números y letras (mínimo 8)">
          </div>
        </div>
        <br><br>
        <input type="submit" name="inicio" id="inicio" value="Aceptar" >
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
      </form>
    </div> 
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
    });
  </script>


</body>
</html>


