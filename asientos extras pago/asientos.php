<?php
$servidor = "localhost";
$usuario = "root";
$cont = "";
$bd = "proyecto";

$con = mysqli_connect($servidor, $usuario, $cont, $bd);
if ($con->connect_error) {
    die("Error en la conexión: " . $con->connect_error);
}
mysqli_select_db($con, $bd);

session_start();

if (isset($_SESSION['errorAsientos'])) {
    echo '<p class="error">' . $_SESSION['errorAsientos'] . '</p>';
    $_SESSION['errorAsientos'] = null;
}

/*$idVuelo = $_SESSION['numeroIDA'];
$queryOcupados = "SELECT * FROM Vuelos WHERE idVuelo = '$idVuelo'";
$resultadoOcupados = mysqli_query($con,$queryOcupados);
$filaOcupados = $resultadoOcupados->fetch_assoc();

$numeroOcupados = $filaOcupados['ocupados'];*/
$numeroOcupados = 2;////////////////////////////////////////BORRAR Y DESCOMENTAR SUPERIORES

$contadorOcupados = 0;

/*$listaViajeros = $_SESSION['listaViajeros'];
$numeroViajeros = count($listaViajeros);*/
$numeroViajeros = 5;////////////////////////////////////////BORRAR Y DESCOMENTAR SUPERIORES

$listaViajeros = array('Blaze,Salinas', 'Will,Brennan', 'Damion,Hartman', 'Quinten,Alford', 'William,Mcintosh');
//////////////////////////////////////////////////////////////BORRAR Y DESCOMENTAR SUPERIORES

$_SESSION['dataIDA'] = "24,AGUASCALIENTES,CANCUN,2016-12-08,10:00,300";/////////////////BORRAR
$_SESSION['dataREG'] = "24,CANCUN,AGUASCALIENTES,2016-12-10,10:00,300";///////////////BORRAR
/*$_SESSION['dataREG'] = "NULL";*/ ///////////////BORRAR

if(!isset($_SESSION['iteracionesAsientos'])) {
    if ($_SESSION['dataREG'] === "NULL") {
        $_SESSION['iteracionesAsientos'] = 1; //Sencillo
    } else {
        $_SESSION['iteracionesAsientos'] = 2; //Redondo
    }
    $datosVuelo = explode(",", $_SESSION['dataIDA']);
    $origen = $datosVuelo[1];
    $destino = $datosVuelo[2];
    $_SESSION['sesionOrigen'] =  $origen;
    $_SESSION['sesionDestino'] = $destino;
} else {
    if($_SESSION['iteracionesAsientos'] > 0) {
        $datosVuelo = explode(",", $_SESSION['dataREG']);
        $origen = $datosVuelo[1];
        $destino = $datosVuelo[2];
        $_SESSION['sesionOrigen'] =  $origen;
        $_SESSION['sesionDestino'] = $destino;
    } else {
        $_SESSION['iteracionesAsientos'] = null;
        header("Location: extras.php");
        exit(0);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Asientos</title>

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

    <link rel="stylesheet" href="estiloAsientos.css">
</head>

<body>
<div class="container">
    <h1>Seleccione sus asientos</h1>
    <h4>Escoja donde sentarse en su vuelo <strong><?php echo "(" . $origen . " - " . $destino . ")" ?></strong></h4>
    <h5>Los asientos se asignarán a cada pasajero en el orden en que se seleccionen.</h5>
    <form action="registrarAsientos.php" method="post" name="formAsientos">
        <div class="row">
            <div class="seatSelection col-md-12">
                <div class="listaViajeros col-md-4">
                    <h4>Lista de pasajeros</h4>
                    <ul class="list-group">
                        <?php
                        for ($i = 0; $i < $numeroViajeros; ++$i) {
                            ?>
                            <li class="list-group-item list-group-item-info elementoListaViajeros">
                                <?php
                                $nombreApellidoViajero = explode(",", $listaViajeros[$i]);
                                $nombre = $nombreApellidoViajero[0];
                                $apellido = $nombreApellidoViajero[1];
                                echo $nombre . " " . $apellido;
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="seatsChart col-md-4">
                    <span class="frente">FRENTE</span>
                    <br>
                    <span class="columnas">A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D</span>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Delanteros - 1
                        </div>
                        <div id="1_A" role="checkbox" value="450.1A" focusable="true"
                             tabindex="-1" class="seatNumber
                             <?php
                        if ($contadorOcupados < $numeroOcupados) {
                            echo " seatUnavailable";
                            $contadorOcupados++;
                        }
                        ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.1_A" name="vectorAsientos[]" value="450.1A">
                        <div id="1_B" role="checkbox" value="450.1B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.1_B" name="vectorAsientos[]" value="450.1B">
                        <div id="1_C" role="checkbox" value="450.1C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.1_C" name="vectorAsientos[]" value="450.1C">
                        <div id="1_D" role="checkbox" value="450.1D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.1_D" name="vectorAsientos[]" value="450.1D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Delanteros - 2
                        </div>
                        <div id="2_A" role="checkbox" value="450.2A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.2_A" name="vectorAsientos[]" value="450.2A">
                        <div id="2_B" role="checkbox" value="450.2B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.2_B" name="vectorAsientos[]" value="450.2B">
                        <div id="2_C" role="checkbox" value="450.2C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.2_C" name="vectorAsientos[]" value="450.2C">
                        <div id="2_D" role="checkbox" value="450.2D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.2_D" name="vectorAsientos[]" value="450.2D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Delanteros - 3
                        </div>
                        <div id="3_A" role="checkbox" value="450.3A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.3_A" name="vectorAsientos[]" value="450.3A">
                        <div id="3_B" role="checkbox" value="450.3B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.3_B" name="vectorAsientos[]" value="450.3B">
                        <div id="3_C" role="checkbox" value="450.3C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.3_C" name="vectorAsientos[]" value="450.3C">
                        <div id="3_D" role="checkbox" value="450.3D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.3_D" name="vectorAsientos[]" value="450.3D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Regulares - 4
                        </div>
                        <div id="4_A" role="checkbox" value="380.4A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.4_A" name="vectorAsientos[]" value="380.4A">
                        <div id="4_B" role="checkbox" value="380.4B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.4_B" name="vectorAsientos[]" value="380.4B">
                        <div id="4_C" role="checkbox" value="380.4C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.4_C" name="vectorAsientos[]" value="380.4C">
                        <div id="4_D" role="checkbox" value="380.4D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.4_D" name="vectorAsientos[]" value="380.4D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Regulares - 5
                        </div>
                        <div id="5_A" role="checkbox" value="380.5A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.5_A" name="vectorAsientos[]" value="380.5A">
                        <div id="5_B" role="checkbox" value="380.5B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.5_B" name="vectorAsientos[]" value="380.5B">
                        <div id="5_C" role="checkbox" value="380.5C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.5_C" name="vectorAsientos[]" value="380.5C">
                        <div id="5_D" role="checkbox" value="380.5D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.5_D" name="vectorAsientos[]" value="380.5D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            Regulares - 6
                        </div>
                        <div id="6_A" role="checkbox" value="380.6A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.6_A" name="vectorAsientos[]" value="380.6A">
                        <div id="6_B" role="checkbox" value="380.6B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.6_B" name="vectorAsientos[]" value="380.6B">
                        <div id="6_C" role="checkbox" value="380.6C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.6_C" name="vectorAsientos[]" value="380.6C">
                        <div id="6_D" role="checkbox" value="380.6D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.6_D" name="vectorAsientos[]" value="380.6D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finales - 7
                        </div>
                        <div id="7_A" role="checkbox" value="300.7A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.7_A" name="vectorAsientos[]" value="300.7A">
                        <div id="7_B" role="checkbox" value="300.7B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.7_B" name="vectorAsientos[]" value="300.7B">
                        <div id="7_C" role="checkbox" value="300.7C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.7_C" name="vectorAsientos[]" value="300.7C">
                        <div id="7_D" role="checkbox" value="300.7D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.7_D" name="vectorAsientos[]" value="300.7D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finales - 8
                        </div>
                        <div id="8_A" role="checkbox" value="300.8A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.8_A" name="vectorAsientos[]" value="300.8A">
                        <div id="8_B" role="checkbox" value="300.8B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.8_B" name="vectorAsientos[]" value="300.8B">
                        <div id="8_C" role="checkbox" value="300.8C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.8_C" name="vectorAsientos[]" value="300.8C">
                        <div id="8_D" role="checkbox" value="300.8D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.8_D" name="vectorAsientos[]" value="300.8D">
                    </div>
                    <div class="seatRow">
                        <div class="seatRowNumber">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Finales - 9
                        </div>
                        <div id="9_A" role="checkbox" value="300.9A" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">1</div>
                        <input type="checkbox" id="checkbox.9_A" name="vectorAsientos[]" value="300.9A">
                        <div id="9_B" role="checkbox" value="300.9B" focusable="true" tabindex="-1"
                             class="separador seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">2</div>
                        <input type="checkbox" id="checkbox.9_B" name="vectorAsientos[]" value="300.9B">
                        <div id="9_C" role="checkbox" value="300.9C" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">3</div>
                        <input type="checkbox" id="checkbox.9_C" name="vectorAsientos[]" value="300.9C">
                        <div id="9_D" role="checkbox" value="300.9D" focusable="true" tabindex="-1"
                             class="seatNumber
                             <?php
                             if ($contadorOcupados < $numeroOcupados) {
                                 echo " seatUnavailable";
                                 $contadorOcupados++;
                             }
                             ?>
                        ">4</div>
                        <input type="checkbox" id="checkbox.9_D" name="vectorAsientos[]" value="300.9D">
                    </div>
                </div>
                <div class="seatsReceipt col-md-4">
                    <p><strong>Asientos seleccionados: <span class="seatsAmount">0</span></strong></p>
                    <ul id="seatsList" class="nav nav-stacked"></ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" id="inputNumeroViajeros" name="inputNumeroViajeros"
                       value="<?php echo $numeroViajeros ?>">
                <input type="hidden" id="ordenAsientos" name="ordenAsientos">
                <button id="botonAsientos" type="submit" class="btn btn-primary btn-lg">Continuar</button>
            </div>
        </div>
        <script src="asientos.js"></script>
    </form>
</div>
</body>
</html>
