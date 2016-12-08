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

if (isset($_SESSION['errorNombreTarjeta'])) {
    echo '<p class="error">' . $_SESSION['errorNombreTarjeta'] . '</p>';
    $_SESSION['errorNombreTarjeta'] = null;
}

/**
 * Obtener datos
 */
/*$idVuelo = $_SESSION['numeroIDA'];*/
$idVuelo = 6;//////////////////////////////BORRAR Y DESCOMENTAR

/*$queryPrecio = "SELECT costo FROM Vuelos WHERE idVuelo='$idVuelo'";
$resultadoPrecio = mysqli_query($con, $queryPrecio);
$filaPrecio = $resultadoPrecio->fetch_assoc();
$precioVuelo = $filaPrecio['costo'];*/
$precioVuelo = 15000;//////////////////////BORRAR Y DESCOMENTAR
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forma de Pago</title>

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

    <script type="text/javascript" src="creditcard.js"></script>

    <script type="text/javascript">
        /**
         * Formatos válidos:
         * Master Card 5500 0000 0000 0004
         * Visa 4111 1111 1111 1111
         * American Express 3400 0000 0000 009
         */
        function revisarTarjeta() {
            var numero = document.getElementById('NumeroTarjeta').value;
            var tipo = document.getElementById('TipoTarjeta').value;
            if (!checkCreditCard(numero, tipo)) {
                alert("Formato de número no válido");
            } else {
                alert("Formato de número válido");
            }
        }
    </script>

    <script type="text/javascript">
        function apartarVuelo() {
            window.location = "vueloApartado.php";
        }
    </script>

    <!-- PDF -->
    <script type="text/javascript" src="jspdf.min.js"></script>
    <script type="text/javascript" src="html2canvas.js"></script>
    <script type="text/javascript">
        function genPDF() {
            html2canvas(document.getElementById("infoPDF"), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL("image/png");
                    var doc = new jsPDF();
                    doc.addImage(img, 'PNG', 20, 20);
                    doc.save('pago.pdf');
                }
            });
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Paga como tú quieras</h1>
    <h4>Seleccione una forma de pago para apartar su vuelo</h4>
    <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle="pill" href="#tarjeta">Tarjeta de Crédito o Débito</a></li>
        <li><a data-toggle="pill" href="#sucursal">Pago en sucursal</a></li>
    </ul>

    <div class="tab-content">
        <div id="tarjeta" class="tab-pane fade in active">
            <div id="divAlerta"></div>
            <h3>Ingrese los datos de la tarjeta</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="pagar.php" method="post" class="form-horizontal col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="nombre" class="control-label col-md-3">Nombre en la tarjeta</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombreContacto"
                                       placeholder="Nombre Completo"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Tipo de tarjeta</label>
                            <div class="col-md-9">
                                <select class="form-control" id="TipoTarjeta" name="tipo">
                                    <option value="MasterCard">Master Card</option>
                                    <option value="Visa">Visa</option>
                                    <option value="AmEx">American Express</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="NumeroTarjeta" class="control-label col-md-3">Número de tarjeta</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="NumeroTarjeta" name="numero"
                                           placeholder="XXXX-XXXX-XXXX-XXXX" autocomplete="off" maxlength="16"
                                           pattern="\d{16}" required>
                                    <div class="input-group-btn">
                                        <button class="btn btn-warning" type="button" onclick="revisarTarjeta()"><i
                                                    class="glyphicon glyphicon-credit-card"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Expiración</label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <select class="form-control" id="selectMes" name="mes">
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="selectAnio" name="anio"> </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="csc" class="control-label col-md-3">CSC</label>
                            <div class="col-md-9">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="codigoSeguridad" name="numSeguridad"
                                           placeholder="Cod Seg" autocomplete="off"
                                           maxlength="3"
                                           pattern="\d{3}" required>
                                </div>
                            </div>
                        </div>
                        <button id="botonPagarTarjeta" type="submit" class="btn btn-primary btn-lg">Apartar vuelo
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="sucursal" class="tab-pane fade">
            <h3>Pague en efectivo</h3>
            <h4>De clic en Descargar PDF para poder realizar su pago en una de las siguientes sucursales y tiendas de
                conveniencia</h4>
            <h6>Pueden aplicar cargos adicionales. La reservación deberá completarse en máximo 48 horas o será
                cancelada.</h6>
            <div class="row">
                <div class="col-md-12">
                    <img class="img-responsive sucursal" src="imagenes/inbursa.png" alt="INBURSA">
                    <img class="img-responsive sucursal" src="imagenes/Farmacias-Benavides.jpg"
                         alt="Farmacias Benavides">
                    <img class="img-responsive sucursal" src="imagenes/Extra.png" alt="extra">
                    <img class="img-responsive sucursal" src="imagenes/farmacias-del-ahorro.png"
                         alt="Farmacias del Ahorro">
                    <img class="img-responsive sucursal" src="imagenes/HSBC.png" alt="HSBC">
                    <img class="img-responsive sucursal" src="imagenes/oxxo.png" alt="OXXO">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a data-toggle="collapse" data-target="#infoPDF" class="colapsarPDF">Colapsar la información del
                        PDF</a>
                    <div class="botonesSucursal">
                        <button id="botonDescargarPDF" type="button" class="btn btn-success btn-lg" onclick="genPDF()">
                            Descargar PDF
                        </button>
                        <button id="botonPagarSucursal" type="button" class="btn btn-primary btn-lg"
                                onclick="apartarVuelo()">Apartar vuelo
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="infoPDF" class="collapse in">
                        <h1>Pago del Vuelo</h1>
                        <h4><strong>Id de vuelo: </strong> <?php echo $idVuelo ?></h4>
                        <h3><strong>Datos de los botelos</strong></h3>
                        <?php
                        /*$listaViajeros = $_SESSION['listaViajeros'];
                        $numeroViajeros = count($listaViajeros);*/
                        $numeroViajeros = 5; //////////////////////BORRAR Y DESCOMENTAR

                        if ($_SESSION['dataREG'] === "NULL") {
                            //sencillo
                            for ($i = 0; $i < 1; $i++) {
                                $datosAsiento = array();
                                for ($j = 0; $j < $numeroViajeros; $j++) {
                                    $datosAsiento[] = explode(".", $_SESSION['vectorRegistroAsientos'][$i][$j]);
                                    echo "<h4><strong>Cliente:</strong>" . $datosAsiento[$j][0] . "</h4>";
                                    echo "<p><strong>Asiento:</strong>" . $datosAsiento[$j][1] . " (" . $datosAsiento[$j][2] . ") $" . $datosAsiento[$j][3] . "</p>";
                                }
                            }
                        } else {
                            //redondo
                            for ($i = 0; $i < 2; $i++) {
                                $datosAsiento = array();
                                for ($j = 0; $j < $numeroViajeros; $j++) {
                                    $datosAsiento[] = explode(".", $_SESSION['vectorRegistroAsientos'][$i][$j]);
                                    echo "<h4><strong>Cliente: </strong>" . $datosAsiento[$j][0] . "</h4>";
                                    echo "<p><strong>Asiento: </strong>" . $datosAsiento[$j][1] . " (" . $datosAsiento[$j][2] . ") $" . $datosAsiento[$j][3] . "</p>";
                                }
                            }
                        }
                        ?>
                        <h4><strong>Precio Vuelo</strong> $ <?php echo $precioVuelo ?> </h4>
                        <h4><strong>Opcionales</strong></h4>
                        <?php
                        if ($_SESSION['pagarMaletas'] > 0) {
                            echo "<p><strong>MALETAS EXTRA</strong> $" . $_SESSION['pagarMaletas'] . "</p>";
                        }
                        if ($_SESSION['pagarAbordaje'] > 0) {
                            echo "<p><strong>PRIORIDAD DE ABORDAJE</strong> $" . $_SESSION['pagarAbordaje'] . "</p>";
                        }
                        if ($_SESSION['pagarVarios'] > 0) {
                            echo "<p><strong>EQUIPO MUSICAL Y DEPORTIVO</strong> $" . $_SESSION['pagarVarios'] . "</p>";
                        }
                        ?>
                        <h3><strong>Total a pagar: </strong> <?php echo $_SESSION['prruTotal'] ?></h3>
                        <img src="imagenes/inbursa_pdf.png" alt="INBURSA">
                        <img src="imagenes/Farmacias-Benavides_pdf.jpg" alt="Farmacias Benavides">
                        <img src="imagenes/Extra_pdf.png" alt="extra">
                        <br>
                        <br>
                        <img src="imagenes/farmacias-del-ahorro_pdf.png" alt="Farmacias del Ahorro">
                        <img src="imagenes/HSBC_pdf.png" alt="HSBC">
                        <img src="imagenes/oxxo_pdf.png" alt="OXXO">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var d = new Date();
    var n = d.getFullYear();
    for (var i = 0; i < 10; i++) {
        var select = document.getElementById("selectAnio");
        select.options[select.options.length] = new Option((n + i).toString(), (n + i).toString());
    }
</script>
</body>
</html>