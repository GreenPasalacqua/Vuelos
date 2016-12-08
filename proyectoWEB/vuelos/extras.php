<?php

    /*****************************/
    $host="localhost";
    $user="root";
    $contraseña="315721";
    $dataBase="Proyecto";
    /*****************************/
/*$con = mysqli_connect($servidor, $usuario, $cont, $bd);
if ($con->connect_error) {
    die("Error en la conexión: " . $con->connect_error);
}
mysqli_select_db($con, $bd);*/

session_start();

$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
$query = "SELECT * FROM PreciosExtra";
$resultado = mysqli_query($laConexion, $query);
$fila = $resultado->fetch_assoc();

$precioMaleta = $fila['maletaExtra'];
$precioPrioridad = $fila['prioridadAbordaje'];
$precioVarios = $fila['equipajesVarios'];

//////prueba datos viajero////////////////////////////BORRAR
/*$numeroViajeros = 5;

if ($_SESSION['dataREG'] === "NULL") {
    //sencillo
    for ($i = 0; $i < 1; $i++) {
        $datosAsiento = array();
        for ($j = 0; $j < $numeroViajeros; $j++) {
            $datosAsiento[] = explode(".", $_SESSION['vectorRegistroAsientos'][$i][$j]);
            echo $datosAsiento[$j][0] . " " . $datosAsiento[$j][1] . " " . $datosAsiento[$j][2] . " " . $datosAsiento[$j][3];
        }
    }
} else {
//redondo
    for ($i = 0; $i < 2; $i++) {
        $datosAsiento = array();
        for ($j = 0; $j < $numeroViajeros; $j++) {
            $datosAsiento[] = explode(".", $_SESSION['vectorRegistroAsientos'][$i][$j]);
            echo $datosAsiento[$j][0] . " " . $datosAsiento[$j][1] . " " . $datosAsiento[$j][2] . " " . $datosAsiento[$j][3];
        }
        echo "<br>";
    }
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Extras</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="estilos.css">
</head>

<body>

<div class="container">
    <h1>Agrega extras para un mejor viaje</h1>
    <h4>Seleccione el servicio que desee agregar o continue para apartar su vuelo</h4>
    <h6>Aplican a todos los vuelos del viaje (escalas y vuelos de vuelta). La prioridad de abordaje se cobra por
        cliente.</h6>
    <div class="row">
        <form action="registrarExtras.php" method="post" class="form-inline">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Maleta Extra</h3>
                        <h4>¡Lleva más contigo!</h4>
                    </div>
                    <div class="panel-body">
                        <img class="img-responsive center-block" src="imagenes/maleta.png" alt="maleta extra">
                        <div class="form-group">
                            <label for="maletas" class="control-label sr-only">Maletas</label>
                            <div class="col-md-6 col-md-offset-3">
                                <input id="maletas" name="nMaletaExtra" class="form-control" type="number"
                                       value="1"
                                       min="0" max="10">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer"><h4>Precio por cada maleta extra: $<?php echo $precioMaleta ?></h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Prioridad de Abordaje</h3>
                        <h4>¡Entra primero al avión!</h4>
                    </div>
                    <div class="panel-body">
                        <img class="img-responsive center-block" src="imagenes/prioridad.png"
                             alt="prioridad de abordaje">
                        <div class="form-group">
                            <span class="etiqueta">¡Se el primero en abordar!</span>
                            <input id="prioridad" name="bPrioridadAbordaje" class="regular-checkbox big-checkbox"
                                   type="checkbox" value="Si">
                            <label for="prioridad"></label>
                        </div>
                    </div>
                    <div class="panel-footer"><h4>Precio: $<?php echo $precioPrioridad ?></h4></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Equipaje deportivo o instrumentos musicales</h3>
                        <h4>¡No dejes de practicar!</h4>
                    </div>
                    <div class="panel-body">
                        <img class="img-responsive center-block" src="imagenes/varios.png"
                             alt="varios">
                        <div class="form-group">
                            <label for="varios" class="control-label sr-only">Equipaje deportivo o instrumentos
                                musicales</label>
                            <div class="col-md-6 col-md-offset-3">
                                <input id="varios" name="nEquipajesVarios" class="form-control" type="number"
                                       value="1"
                                       min="0" max="8">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <h4>Precio por cada equipo extra: $<?php echo $precioVarios ?></h4>
                        <h5>No olvides llevar tu equipo dentro de su estuche, caja o funda</h5>
                    </div>
                </div>
            </div>
            <button id="botonContinuar" type="submit" class="btn btn-primary btn-lg">Continuar</button>
        </form>
    </div>
</div>

<!-- Plugin para input type="number" -->
<script src="bootstrap-number-input.js"></script>
<script>
    $('#maletas').bootstrapNumber({
        upClass: 'primary',
        downClass: 'primary'
    });
    $('#varios').bootstrapNumber({
        upClass: 'primary',
        downClass: 'primary'
    });
</script>

</body>
</html>