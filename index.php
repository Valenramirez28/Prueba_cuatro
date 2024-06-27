<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Vehículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/index.jpg);
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 1px 3px 15px rgba(0, 0, 0, 0.1); /* Box-shadow en todos los lados */
            animation: fadeIn 1s ease-in-out;
            height: 330px;
            width: 35%;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
       
        h2 {
            margin: 0 0 20px;
            font-family: 'Algerian', sans-serif;
            text-align: center;
            color: #333;
            font-size: 30px;
            margin-bottom: 40px; 
            margin-left: 111px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            margin-left: 26px; 
        }
        input[type="text"] {
            width: 111%;
            padding: 10px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-left: 26px; 
        }
        button {
            width: 111%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-left: 26px; 
            margin-top: 15px; 
            margin-bottom: 20px; 
        }
        button:hover {
            background-color: #555;
        }
        

        Media Queries for Responsiveness 
        @media (max-width: 1200px) {
            .wrapper {
                flex-direction: row;
                padding: 20px;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 30px;
                margin-top: 25px;
                margin-left: -1px;
            }
            
            input[type="text"] {
                width: 100%;
                margin-bottom: 25px;
                margin-left: -1px;
            }

            label{
                margin-left: -1px;
            }

            button {
                font-size: 14px;
                padding: 8px;
                width: 100%;
                margin-left: -1px;
            }
        }

        @media (max-width: 1024px) {
            .wrapper {
                flex-direction: column;
                align-items: center;
                padding: 20px;
                margin-top: -15px;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 30px;
                margin-top: 25px;
                margin-left: -1px;
            }
            
            input[type="text"] {
                width: 100%;
                margin-bottom: 25px;
                margin-left: -1px;
            }

            label{
                margin-left: -1px;
            }

            button {
                font-size: 14px;
                padding: 8px;
                width: 100%;
                margin-left: -1px;
            }
          
        }

        @media (max-width: 480px) {
            .wrapper {
                width: 16%;
                padding: 10px;
                margin-top: -90px;
            }
            h2 {
                font-size: 20px;
                margin-bottom: 20px;
                margin-top: -90px;
            }
            button {
                font-size: 12px;
                padding: 6px;
            }
            .card p {
                font-size: 14px;
            }
            
        }

        @media (max-width: 768px) {
            .wrapper {
                padding: 15px;
                margin-top: -20px;
                width: 70%;
            }
            h2 {
                font-size: 24px;
                margin-bottom: 30px;
                margin-top: 25px;
                margin-left: -1px;
            }
            
            input[type="text"] {
                width: 100%;
                margin-bottom: 25px;
                margin-left: -1px;
            }

            label{
                margin-left: -1px;
            }

            button {
                font-size: 14px;
                padding: 8px;
                width: 100%;
                margin-left: -1px;
            }
          
        }

        @media (max-width: 480px) {
            .wrapper {
                width: 16%;
                padding: 10px;
            }
            h2 {
                font-size: 20px;
                margin-bottom: 20px;
                margin-top: -90px;
            }
            button {
                font-size: 12px;
                padding: 6px;
            }
            .card p {
                font-size: 14px;
            }
        } 
    </style>
</head>
<body>
<div class="wrapper">
        <div class="container">
            <h2>Buscar Vehículo</h2>
            <form method="post" action="model/usuario/buscar.php">
                <label for="documento">Documento:</label>
                <input type="text" id="documento" name="buscar" placeholder="Ingrese su documento">
                
              <!-- 
              <input type="text" id="documento" name="buscar" pattern="[0-9]{8,10}"  title="El documento de be contener solo numeros de 8 a 10 digitos" placeholder="Ingrese su documento">
  
              <label for="placa">Placa:</label>
                <input type="text" id="placa" name="buscar" pattern="[0-9A-Z-]{5,10}" title="La placa debe contener numeros y letras minimo 5 caracteres" placeholder="Ingrese la placa del vehículo" >
    -->
                
                <button type="submit">Buscar</button>
            </form>
        </div>
        
    </div>


</body>
</html>
