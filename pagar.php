<?php
if (isset($_POST['nombreContacto']) && isset($_POST['tipo']) && isset($_POST['numero']) && isset($_POST['numSeguridad'])
    && isset($_POST['mes']) && isset($_POST['anio'])
) {

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

    /**
     * Obtener id de vuelo
     */
    $idVuelo = $_SESSION['numeroIDA'];

    $nombreContacto = $_POST['nombreContacto'];
    $tipo = $_POST['tipo'];
    $numero = $_POST['numero'];
    $numSeguridad = $_POST['numSeguridad'];
    $fechaV = $_POST['anio'] . '-' . $_POST['mes'] . '-' . '01';
    $fechaPago = date('Y-m-d');
    $monto = $_SESSION['prruTotal'];

    $queryContacto = "SELECT nombreApellido FROM Contacto WHERE idVuelo='$idVuelo'";
    $resultadoContacto = mysqli_query($con, $queryContacto);
    $filaContacto = $resultadoContacto->fetch_assoc();
    $nombreContactoTabla = str_replace("_", " ", $filaContacto['nombreApellido']);

    if ($nombreContacto != $nombreContactoTabla) {
        $_SESSION['errorNombreTarjeta'] = "El nombre en la tarjeta debe coincidir con el nombre del Contacto";
        header("Location: pago.php");
        exit(0);
    } else {
        $queryPago = "INSERT INTO Pago (nombreContacto,tipo,numero,numSeguridad,fechaV,fechaPago,monto) VALUES('$nombreContacto','$tipo','$numero,'$numSeguridad,'$fechaV','$fechaPago','$monto')";
        if ($con->query($queryPago) === TRUE) {
            header("Location: vueloApartado.php");
            exit(0);
        } else {
            echo "Error: " . $con->error . PHP_EOL;
        }
    }
    /**
     * Liberar memoria y cerrar conexión
     */
    mysqli_free_result($resultadoContacto);
    mysqli_close($con);
}