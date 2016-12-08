<!DOCTYPE html>
<html>
<?php 
	$host="localhost";
	$user="root";
	$contraseña="315721";
	$dataBase="Proyecto";

if($_POST["sec"]){
	$dataIda=explode("//", $_POST["sec"]);
	$idAvionIda=explode(":", $dataIda[0]);
	session_start();
	$_SESSION["avionIda"]=$idAvionIda[1];
}

if($_POST["vuelta"]){
	$control="asignado";
	$fechaRegreso=$_POST["vuelta"];
}else{
	$control="sinAsignar";
}

if(isset($_GET["data"])){
	//echo "funciona <br>";
	$infoVuelo=explode("//", $_GET["data"]);
	$fechaVuelta=$_GET["reg"];
	$control="seleccion";
}

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EL PERRO VOLADOR</title>
 
 	<link rel="stylesheet" type="text/css" href="../css/estilos2.css">
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
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
		});
	</script>
  </head>
      <section class="menuBar">
      <ul class="nav nav-pills nav-justified">
        <li role="presentation" class="active"><a href="../index.php">Home</a></li>
        <li role="presentation"><a href="#">Check-in</a></li>
        <li role="presentation"><a href="#">No se que poner aqui</a></li>
      </ul>
    </section>
  <body>
  	<section class="centro">
  		<section class="cuerpo">
  			<?php 
  				if($control=="sinAsignar"){
  					echo "<form method='post' action='vueltaVuelo.php'>";
	  					//echo "<section>";
				          echo "<label>Fecha de partida</label>";
				          echo "<input type='date' name='vuelta' required>"; 
				        //echo "</section>";
				        echo "<button type='submit' class='btn btn-success'>Enviar</button>";
	  				echo "</form>";
  				}elseif($control=="asignado"){
  					session_start();
  					$avionA=$_SESSION["avionIda"];
  					echo "<span>Numero del avion: $avionA, viaje de ida</span>";
  					echo "<label class='mensajes'>$fechaRegreso</label>";
  					$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
  					$dataIda="SELECT * FROM Vuelos WHERE idVuelo='$avionA'";
  					$resultadoIda=mysqli_query($laConexion,$dataIda);
  					while($row=mysqli_fetch_assoc($resultadoIda)){
  						$origen=$row["origen"];
  						$destino=$row["destino"];
  						$fechaIda=$row["llego"];
  						$horaIda=$row["horaLlego"];
  						echo "<p>";
  							echo "<label class='mensajes'>";
  							echo "de <b>$origen</b> a <b>$destino</b> el dia <b>$fechaIda</b> a las <b>$horaIda</b>";
  							echo "</label>";
  						echo "</p>";
  					}

  					$viajeA=$avionA."//".$origen."//".$destino."//".$fechaIda."//".$horaIda;

  					$vueloVuelta="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino' AND voy='$fechaRegreso'";
  					$resultadoVuelta=mysqli_query($laConexion,$vueloVuelta);
  					$i=0;
  					while($row=mysqli_fetch_assoc($resultadoVuelta)){
  						$bitacoraVuelta[$i]=$row["voy"];
  						$i++;
  					}
  					$fechasVuelos=array_values(array_unique($bitacoraVuelta));
  					$tamaño=sizeof($fechasVuelos);
  					if($tamaño!=0){
  						echo "<span>Vuelos encontrado</span>";
  						for ($i=0; $i < $tamaño; $i++) { 
  							echo "<a href=vueltaVuelo.php?data=$viajeA&reg=$fechasVuelos[$i]>$fechasVuelos[$i]</a>";
  						}
  					}else{
  						echo "<span>No hay vuelos encontrados en tales fechas</span>";
  						echo "<span>sugerencias de vuelos</span>";
  						$niPedo="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino'";
  						$resultadoNiPedo=mysqli_query($laConexion,$niPedo);
  						$i=0;
  						while ($row=mysqli_fetch_assoc($resultadoNiPedo)){
  							$bitacoraVuelta[$i]=$row["voy"];
  							$i++;
  						}
  						$fechasVuelos=array_values(array_unique($bitacoraVuelta));
  						$tamaño=sizeof($fechasVuelos);
  						if($tamaño!=0){
  							echo "<label class='mensajes'>alternativas disponibles...</label>";
  							for ($i=0; $i < $tamaño; $i++) { 
  								echo "<a href=vueltaVuelo.php?data=$viajeA&reg=$fechasVuelos[$i]>$fechasVuelos[$i]</a>";
  							}
  						}else{
  							echo "<span>no hay nada en nuestra base de datos con eso!</span>";
  						}
  					}
  				}elseif($control=="seleccion"){
  					//echo "a trabajar con lo que falta <br>";
  					echo "<span>$fechaVuelta</span>";
  					$idVueloA=$infoVuelo[0];
  					$origen=$infoVuelo[1];
  					$destino=$infoVuelo[2];
  					//echo "origen: $origen<br>";
  					//echo "destino: $destino<br>";
  					$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
  					$vuelosDia="SELECT * FROM Vuelos WHERE origen='$origen' AND destino='$destino' AND voy='$fechaVuelta'";
  					$resultDia=mysqli_query($laConexion,$vuelosDia);
  					echo "<form method='post' action='viajeros.php' name='formu' id='formu' class='muestraVuelos'>";
  					while($row=mysqli_fetch_assoc($resultDia)){
  						$idVueloB=$row["idVuelo"];
  						$orVuelo=$row["origen"];
  						$deVuelo=$row["destino"];
  						$horaReg=$row["horaVoy"];
  						$precioReg=$row["costo"];
  						echo "<div class='infoVuelo radio'>";
								echo "<label class='mensajes'>";
								echo "<input type='radio' name='sec' id='sec' value='VueloA:$idVueloA//VueloB:$idVueloB//Redondo'>";
								echo "Avion: <b>$idVueloB</b>";
								echo ", de <b>$deVuelo</b> a <b>$orVuelo</b><br>";
								echo "el vuelo sale a las: <b>$horaReg</b>, $ $precioReg<br><br>";
								echo "</label>";
  						echo "</div>";
  					}
  					echo "<input type='button' id='botonR' class='btn btn-success' value='Enviar'>";
  					echo "</form>";
  				}
  			$laConexion->close();
  			?>
  		</section>
  	</section>
    <footer>
    <section>
      <span>universidad autonoma de aguascalientes UAA | isc | 5°c</span>
      <span>oscar antonio hernández mojica</span>
      <span>luis daniel reyna pérez</span>
    </section>
  </footer>
  <script src="../js/bootstrap.min.js"></script>
  </body>
</html>