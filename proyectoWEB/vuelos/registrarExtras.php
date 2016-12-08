<?php
if (isset($_POST['nMaletaExtra']) && ctype_digit($_POST['nMaletaExtra']) && $_POST['nMaletaExtra'] >= 0
    && isset($_POST['nEquipajesVarios']) && ctype_digit($_POST['nEquipajesVarios']) && $_POST['nEquipajesVarios'] >= 0
) {

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

    /**
     * Obtener precios
     */
    $laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
    $queryPrecios = "SELECT * FROM PreciosExtra";
    $resultadoPrecios = mysqli_query($laConexion, $queryPrecios);
    $filaPrecios = $resultadoPrecios->fetch_assoc();

    $precioMaleta = $filaPrecios['maletaExtra'];
    $precioPrioridad = $filaPrecios['prioridadAbordaje'];
    $precioVarios = $filaPrecios['equipajesVarios'];

    /**
     * Obtener id de vuelo
     */
    $idVuelo = $_SESSION['numeroIDA'];

    /**
     * Obtener que opciones extras se solicitan
     */
    $nMaletaExtra = $_POST['nMaletaExtra'];

    if (isset($_POST['bPrioridadAbordaje']) && $_POST['bPrioridadAbordaje'] == 'Si') {
        $bPrioridadAbordaje = true;
    } else {
        $bPrioridadAbordaje = false;
    }

    $nEquipajesVarios = $_POST['nEquipajesVarios'];

    /**
     * Tipo de vuelo
     */
    $queryTipoVuelo = "SELECT escala,clase FROM Vuelos WHERE idVuelo='$idVuelo'";
    $resultadoTipoVuelo = mysqli_query($laConexion, $queryTipoVuelo);
    $filaTipoVuelo = $resultadoTipoVuelo->fetch_assoc();

    $escalas = explode(",", $filaTipoVuelo['escala']);
    $claseVuelo = $filaTipoVuelo['clase'];

    /**
     * Número de viajeros
     */
    $numeroViajeros = $_SESSION['totalV'];
    //$numeroViajeros = 5; //////////////////////BORRAR Y DESCOMENTAR SUPERIORES

    /**
     * Calcular precios a pagar
     */
    if (count($escalas) > 0) {
        $cantidadTotalMaletas = $nMaletaExtra * count($escalas);
        $cantidadTotalVarios = $nEquipajesVarios * count($escalas);
        if ($bPrioridadAbordaje == true) {
            $cantidadTotalAbordaje = count($escalas);
        } else {
            $cantidadTotalAbordaje = 0;
        }
    } else {
        $cantidadTotalMaletas = $nMaletaExtra;
        $cantidadTotalVarios = $nEquipajesVarios;
        if ($bPrioridadAbordaje == true) {
            $cantidadTotalAbordaje = 1;
        } else {
            $cantidadTotalAbordaje = 0;
        }
    }

    $cantidadTotalAbordaje *= $numeroViajeros;

    if ($claseVuelo == false) { //Redondo
        $cantidadTotalMaletas *= 2;
        $cantidadTotalVarios *= 2;
        $cantidadTotalAbordaje *= 2;
    }

    $_SESSION['pagarMaletas'] = $precioMaleta * $cantidadTotalMaletas;
    $_SESSION['pagarVarios'] = $precioVarios * $cantidadTotalVarios;
    $_SESSION['pagarAbordaje'] = $precioPrioridad * $cantidadTotalAbordaje;

    /**
     * Sumar al total a pagar
     */
    $_SESSION['prruTotal'] += $_SESSION['pagarMaletas'];
    $_SESSION['prruTotal'] += $_SESSION['pagarVarios'];
    $_SESSION['prruTotal'] += $_SESSION['pagarAbordaje'];

    /**
     * Actualizar BD
     */
    $queryExtras = "UPDATE Contacto SET nMaletaExtra='$nMaletaExtra', bPrioridadAbordaje='$bPrioridadAbordaje', nEquipajesVarios='$nequipajesVarios' WHERE idVuelo='$idVuelo'";

    if ($laConexion->query($queryExtras) === TRUE) {
        header("Location: pago.php");
        exit(0);
    } else {
        echo "Error: " . $laConexion->error . PHP_EOL;
    }

    /**
     * Liberar memoria y cerrar conexión
     */
    mysqli_free_result($resultadoPrecios);
    mysqli_free_result($resultadoTipoVuelo);
    mysqli_close($laConexion);
}