<?php
session_start();
if(isset($_SESSION['iteracionesAsientos'])) {////////////////////////AÑADIR A CAPTURA DE PASAJEROS ANTES DE REDIRIGIR
    $_SESSION['iteracionesAsientos'] = null;
}
if(isset($_SESSION['vectorRegistroAsientos'])) {////////////////////////AÑADIR A CAPTURA DE PASAJEROS ANTES DE REDIRIGIR
    $_SESSION['vectorRegistroAsientos'] = null;
}
header("Location: asientos.php");
exit(0);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>prueba</title>
</head>
<body>
HOLA
</body>
</html>
