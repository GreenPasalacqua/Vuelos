<?php
if (isset($_POST['nombreContacto']) && isset($_POST['tipo']) && isset($_POST['numero']) && isset($_POST['numSeguridad'])
    && isset($_POST['mes']) && isset($_POST['anio'])
) {

    /*****************************/
    $host="localhost";
    $user="root";
    $contraseña="315721";
    $dataBase="Proyecto";
    /*****************************/
    $laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);

    /*$con = mysqli_connect($servidor, $usuario, $cont, $bd);
    if ($con->connect_error) {
        die("Error en la conexión: " . $con->connect_error);
    }
    mysqli_select_db($con, $bd);*/

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
    $resultadoContacto = mysqli_query($laConexion, $queryContacto);
    $filaContacto = $resultadoContacto->fetch_assoc();
    $nombreContactoTabla = str_replace("_", " ", $filaContacto['nombreApellido']);

    if ($nombreContacto != $nombreContactoTabla) {
        $_SESSION['errorNombreTarjeta'] = "El nombre en la tarjeta debe coincidir con el nombre del Contacto";
        header("Location: pago.php");
        exit(0);
    } else {
        $nombreContacto = $_SESSION["contacto"]=$contacto;
        $queryPago = "INSERT INTO Pago (nombreContacto,tipo,numero,fechaV,monto,numSeguridad,fechaPago) VALUES('$nombreContacto','$tipo','$numero','$fechaV','$monto','$numSeguridad','$fechaPago')";
        if ($laConexion->query($queryPago) === TRUE) {
            header("Location: vueloApartado.php");
            exit(0);
        } else {
            echo "Error: " . $laConexion->error . PHP_EOL;
        }
        //header("Location: vueloApartado.php");///////////////////BORRAR Y DESCOMENTAR SUPERIORES
        exit(0);
    }
    /**
     * Liberar memoria y cerrar conexión
     */
    mysqli_free_result($resultadoContacto);
    mysqli_close($laConexion);
}