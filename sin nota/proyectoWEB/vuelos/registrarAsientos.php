<?php
    /*****************************/
    $host="localhost";
    $user="root";
    $contraseña="315721";
    $dataBase="Proyecto";
    /*****************************/
    $laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);

session_start();

if (isset($_POST['vectorAsientos'])) {

    $asientosSeleccionados = $_POST['vectorAsientos'];

    if (empty($asientosSeleccionados)) {
        $_SESSION['iteracionesAsientos'] = null;
        $_SESSION['vectorRegistroAsientos'] = null;
        $_SESSION['errorAsientos'] = "Debes seleccionar los asientos de los pasajeros";
        header("Location: asientos.php");
        exit(0);
    } else {
        $numeroAsientos = count($asientosSeleccionados);

        if ($numeroAsientos < $_POST['inputNumeroViajeros']) {
            $_SESSION['iteracionesAsientos'] = null;
            $_SESSION['vectorRegistroAsientos'] = null;
            $_SESSION['errorAsientos'] = "No se seleccionaron los asientos de todos los pasajeros";
            header("Location: asientos.php");
            exit(0);
        }

        if ($_SESSION['iteracionesAsientos'] > 0) {

            $listaViajeros = $_SESSION['listaViajeros'];

            $stringAsientosSeleccionadosEnOrden = $_POST['ordenAsientos'];
            $asientosSeleccionadosEnOrden = explode(",", $stringAsientosSeleccionadosEnOrden);

            if (!isset($_SESSION['vectorRegistroAsientos'])) {
                $_SESSION['vectorRegistroAsientos'] = array();
            }
            $registroAsientos = array();

            for ($i = 0; $i < $numeroAsientos; ++$i) {
                $nombreApellidoViajero = explode(",", $listaViajeros[$i]);
                $nombre = $nombreApellidoViajero[0];
                $apellido = $nombreApellidoViajero[1];

                $datosAsiento = explode(".", $asientosSeleccionadosEnOrden[$i]);
                $filaColumna = $datosAsiento[1];

                $origen = $_SESSION['sesionOrigen'];
                $destino = $_SESSION['sesionDestino'];
                $origenDestino = $origen . " - " . $destino;

                $precio = $datosAsiento[0];
                /**
                 * Sumar al total a pagar
                 */
                $_SESSION['prruTotal'] += $precio;

                $registroAsientos[$i] = $nombre . " " . $apellido . "." . $filaColumna . "." . $origenDestino . "." . $precio;
            }

            $_SESSION['vectorRegistroAsientos'][] = $registroAsientos;

            --$_SESSION['iteracionesAsientos'];
            header("Location: asientos.php");
            exit(0);
        }
    }
} else {
    $_SESSION['iteracionesAsientos'] = null;
    $_SESSION['vectorRegistroAsientos'] = null;
    $_SESSION['errorAsientos'] = "Debes seleccionar los asientos de los pasajeros";
    header("Location: asientos.php");
    exit(0);
}