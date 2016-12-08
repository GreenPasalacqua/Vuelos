<!DOCTYPE html>
<html>
<?php
	$host="localhost";
	$user="root";
	$contraseña="315721";
	$dataBase="Proyecto";

	$origen=$_POST["origen"];
	$destino=$_POST["destino"];
	//echo "$origen <br>";
	//echo "$destino <br>";
	$fechaSalida=$_POST["fecha-salida"];
	/*$fechaRegreso=$_POST["fecha-regreso"];
	echo "$fechaRegreso <br>";
	session_start();
	$_SESSION["regreso"]=$fechaRegreso;*/

	$tipo=$_POST["tipo"]; 

	if(isset($_GET['dateV'])){
			$dateVuelo=$_GET['dateV'];
			$tipo=$_GET['t'];
			$origen=$_GET['o'];
			$destino=$_GET['d'];
		}else{
			$dateVuelo="sinFecha";
	}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EL PERRO VOLADOR</title>
 
 	<link rel="stylesheet" type="text/css" href="../css/estilos2.css">
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>


<!--Esto es para que funcione el input/date-time en firefox-->
	<!-- cdn for modernizr, if you haven't included it already -->
  <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
	<!-- polyfiller file to detect and load polyfills -->
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
	<script>
  		webshims.setOptions('waitReady', false);
  		webshims.setOptions('forms-ext', {types: 'date'});
  		webshims.polyfill('forms forms-ext');
	</script>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#botonR").click(function(){
				alert($('input:radio[name=sec]:checked').val());
				$("#formu").submit();
			})
			$("#botonS").click(function(){
				alert($('input:radio[name=sec]:checked').val());
				$("#formu").submit();
			})
		});
	</script>
  </head>
<body>
    <section class="menuBar">
    	<ul class="nav nav-pills nav-justified">
    		<li role="presentation" class="active"><a href="../index.php">Home</a></li>
    		<li role="presentation"><a href="#">Check-in</a></li>
    		<li role="presentation"><a href="#">No se que poner aqui</a></li>
    	</ul>
    </section>
<section class="centro">
	<section class="cuerpo">
		<?php
		$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
				echo "<span>Vuelo de ida prru!</span>";
				$consultaIda="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino' AND llego='$fechaSalida'";
				$resultadoIda=mysqli_query($laConexion,$consultaIda);
				if($dateVuelo=="sinFecha"){
				if($laConexion){
					$i=0;
					while($row=mysqli_fetch_assoc($resultadoIda)){
						//$bitacoraIda[$i]=$row["llego"]." \n$"."precio";
						$bitacoraIda[$i]=$row["llego"];
						$i++;
					}
					$fechaVuelo=array_values(array_unique($bitacoraIda));
					$tamaño=sizeof($fechaVuelo);
					if($tamaño!=0){
						echo "<label class='mensajes'>Vuelos disponibles</label>";
						for ($i=0; $i < $tamaño; $i++) { 
							echo "<a href='idaVuelo.php?dateV=$fechaVuelo[$i]&t=$tipo&o=$origen&d=$destino'>$fechaVuelo[$i]</a>";
						}
					}else{
						echo "<span>No hay vuelos disponibles el dia $fechaSalida</span>";
						$niPedo="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino'";
						$resutNiPedo=mysqli_query($laConexion,$niPedo);
						$i=0;
						while($row=mysqli_fetch_assoc($resutNiPedo)){
							//$bitacoraIda[$i]=$row["llego"]." \n$"."precio";
							$bitacoraIda[$i]=$row["llego"];
							$i++;
						}
						$fechaVuelo=array_values(array_unique($bitacoraIda));
						$tamaño=sizeof($fechaVuelo);
						if($tamaño!=0){
							echo "<label class='mensajes'>Otros vuelos disponibles...</label>";
							for ($i=0; $i < $tamaño; $i++) { 
								echo "<a href='idaVuelo.php?dateV=$fechaVuelo[$i]&t=$tipo&o=$origen&d=$destino'>$fechaVuelo[$i]</a>";
							}

						}else{
							echo "<span>No hay vuelos con tales destinos</span>";
						}
					}
				}
				}
				if($dateVuelo!="sinFecha"){
					if($tipo=="sencillo"){
						echo "<span>sencillo</span>";
						echo "<label class='mensajes'>$dateVuelo</label>";
						$VuelosDia="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino' AND llego='$dateVuelo'";
						$resultDia=mysqli_query($laConexion,$VuelosDia);
						echo "<form method='post' action='viajeros.php' name='formu' id='formu' class='muestraVuelos'>";
							while ($row=mysqli_fetch_assoc($resultDia)) {
							$idVuelo=$row["idVuelo"];
							$orVuelo=$row["origen"];
							$deVuelo=$row["destino"];
							$horaIda=$row["horaLlego"];
							$precioIda=$row["costo"];
							echo "<div class='infoVuelo radio'>";
								echo "<label class='mensajes'>";
								echo "<input type='radio' name='sec' value='VueloA:$idVuelo//Sencillo'>";
								echo "Avion: <b>$idVuelo</b>";
								echo ", de <b>$orVuelo</b> a <b>$deVuelo</b><br>";
								echo "el vuelo sale a las: <b>$horaIda</b>, $ $precioIda<br>";
								echo "</label>";
							echo "</div>";
							}
							echo "<input type='button' id='botonS' value='Enviar' class='botonEnviar btn btn-success'>";
						echo "</form>";
					}else{
						echo "<span>redondo</span>";
						echo "<label class='mensajes'>$dateVuelo</label>";
						$VuelosDia="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino' AND llego='$dateVuelo'";
						$resultDia=mysqli_query($laConexion,$VuelosDia);
						echo "<form method='post' action='vueltaVuelo.php' name='formu' id='formu' class='muestraVuelos'>";
							while ($row=mysqli_fetch_assoc($resultDia)) {
							$idVuelo=$row["idVuelo"];
							$orVuelo=$row["origen"];
							$deVuelo=$row["destino"];
							$horaIda=$row["horaLlego"];
							$precioIda=$row["costo"];
							echo "<div class='infoVuelo radio'>";
								echo "<label class='mensajes'>";
								echo "<input type='radio' name='sec' id='sec' value='VueloA:$idVuelo//Redondo'>";
								echo "Avion: <b>$idVuelo</b>";
								echo ", de <b>$orVuelo</b> a <b>$deVuelo</b><br>";
								echo "el vuelo sale a las: <b>$horaIda</b> $ $precioIda<br>";
								echo "</label>";
							echo "</div>";
							}
						echo "<input type='button' id='botonR' value='Enviar' class='botonEnviar btn btn-success'>";
						echo "</form>";
					}
				}
		$laConexion->close();
		?>
	</section>
</section>
</body>
<footer>
  	<section>
  		<span>universidad autonoma de aguascalientes UAA | isc | 5°c</span>
  		<span>oscar antonio hernández mojica</span>
  		<span>luis daniel reyna pérez</span>
  	</section>
 </footer>
  <script src="../js/bootstrap.min.js"></script>
</html>