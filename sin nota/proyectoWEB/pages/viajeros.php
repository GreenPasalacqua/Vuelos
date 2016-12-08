<!DOCTYPE html>
<html>
<?php 

	/*****************************/
	$host="localhost";
	$user="root";
	$contraseña="315721";
	$dataBase="Proyecto";
	/*****************************/

	//$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);

session_start();

	if($_POST["sec"]){
		$valor=$_POST["sec"];
		$info=explode("//", $valor);
		$tamaño=sizeof($info);
		if($tamaño<3){
			if($info[1]=="Sencillo"){
				//echo "Esto es para un vuelo sencillo <br>";
				$vueloInfoA=explode(":", $info[0]);
				$numIda=$vueloInfoA[1];
				$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
				$consultaIda="SELECT * FROM Vuelos WHERE idVuelo='$numIda'";
				$resultado=mysqli_query($laConexion,$consultaIda);
				while($row=mysqli_fetch_assoc($resultado)){
  						$origen=$row["origen"];
  						$destino=$row["destino"];
  						$fechaIda=$row["llego"];
  						$horaIda=$row["horaLlego"];
  						$costo=$row["costo"];
  					}
  					$dataIDA=$numIda.",".$origen.",".$destino.",".$fechaIda.",".$horaIda.",".$costo;
  					//echo "$dataIDA<br>";
  					//session_start();
  					$_SESSION["numeroIDA"]=$numIda;
  					$_SESSION["numeroREG"]="NULL";
  					$_SESSION["dataIDA"]=$dataIDA;
  					$_SESSION["dataREG"]="NULL";
			}
		}elseif ($tamaño>=3) {
			if($info[2]="Redondo"){
				//echo "Esto es para un vuelo redondo <br>";
				$vueloInfoA=explode(":", $info[0]);
				$vueloInfoB=explode(":", $info[1]);
				$numIda=$vueloInfoA[1];
				$numReg=$vueloInfoB[1];
				$laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
				$consultaIda="SELECT * FROM Vuelos WHERE idVuelo='$numIda'";
				$resultado=mysqli_query($laConexion,$consultaIda);
				while($row=mysqli_fetch_assoc($resultado)){
  						$origenA=$row["origen"];
  						$destinoA=$row["destino"];
  						$fechaIda=$row["llego"];
  						$horaIda=$row["horaLlego"];
  						$costoA=$row["costo"];
  						//echo "$costoA<br>";
  					}
  					$dataIDA=$numIda.",".$origenA.",".$destinoA.",".$fechaIda.",".$horaIda.",".$costoA;
  					//echo "$dataIDA<br>";
  					//session_start();
  					//$_SESSION["dataIDA"]=$dataIDA;
  				$consultaReg="SELECT * FROM Vuelos WHERE idVuelo='$numReg'";
				$resultado=mysqli_query($laConexion,$consultaReg);
				while($row=mysqli_fetch_assoc($resultado)){
  						$origenB=$row["destino"];
  						$destinoB=$row["origen"];
  						$fechaReg=$row["voy"];
  						$horaReg=$row["horaVoy"];
  						$costoB=$row["costo"];
  						//echo "$costoB<br>";
  					}
  					$dataREG=$numReg.",".$origenB.",".$destinoB.",".$fechaReg.",".$horaReg.",".$costoB;
  					//echo "$dataIDA<br>";
  					//echo "$dataREG<br>";
  					//session_start();
  					$_SESSION["numeroIDA"]=$numIda;
  					$_SESSION["numeroREG"]=$numReg;
  					$_SESSION["dataIDA"]=$dataIDA;
  					$_SESSION["dataREG"]=$dataREG;
			}
		}
	}else{
		//echo "<label>Necesario recargar</label>";
	}
	if($_POST["adultos"]){
		$control="tomaDatos";
		$adultos=$_POST["adultos"];
		$niños=$_POST["niños"];
		$infantes=$_POST["infantes"];
		$totalV=$adultos+$niños+$infantes;
	}else{
		$control="sinControl";
	}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EL PERRO VOLADOR</title>
 
 	<link rel="stylesheet" type="text/css" href="../css/estilos2.css">
 	<link rel="stylesheet" type="text/css" href="../css/modales.css">
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
			if($control=="sinControl"){
				echo "<label class='mensaje'>Quienes y cuantos prru...</label>";
				echo "<section class='infoVuelo'>";
					if($_SESSION["dataIDA"]){
						$recoveryA=explode(",", $_SESSION["dataIDA"]);
						$tamaño=sizeof($recoveryA);
						//ejemplo: 727,AGUASCALIENTES,CHIAPAS,2016-12-08,11:00:00,1250.00
						echo "<div>";
							echo "<span>Vuelo de ida</span>";
							echo "<div>";
								echo "Numero del vuelo: $recoveryA[0]<br>";
								echo "De $recoveryA[1] a $recoveryA[2]<br>";
								echo "Fecha de salida: $recoveryA[3]<br>";
								echo "Hora de salida: $recoveryA[4]<br>";
								echo "Precio del vuelo: $ $recoveryA[5]";
								//echo "<label>Costo del viajesito: $ $recoveryA[5]</label>";
							echo "</div>";
						echo "<div>";
						echo "<hr>";
						if($_SESSION["dataREG"]!="NULL"){
							$recoveryB=explode(",", $_SESSION["dataREG"]);
							echo "<div>";
								echo "<span>Vuelo de regreso</span>";
								echo "<div>";
									echo "Numero del vuelo: $recoveryB[0]<br>";
									echo "De $recoveryB[1] a $recoveryB[2]<br>";
									echo "Fecha de salida: $recoveryB[3]<br>";
									echo "Hora de salida: $recoveryB[4]<br>";
									echo "Precio del vuelo: $ $recoveryB[5]<br>";
								echo "</div>";
							echo "</div>";
						}
						if($_SESSION["dataREG"]=="NULL"){
							echo "<label class='mensajes'>Costo del viajesito: $ $recoveryA[5]</label>";
						}else{
							$Total=$recoveryA[5]+$recoveryB[5];
							echo "<hr>";
							echo "<label class='mensajes'>Costo del viajesito: $ $Total</label>";
						}
					}
				echo "</section>";
				echo "<form method='post' action='viajeros.php' class='cuantos'>";
				echo "<div class='numero'>";
					echo "<label>adultos:</label>";
					echo "<input type='number' name='adultos' min='1' max='9' required>";
				echo "</div>";
				echo "<div class='numero'>";
					echo "<label>niños:</label>";
					echo "<input type='number' name='niños' min='0' max='9'>";
				echo "</div>";
				echo "<div class='numero'>";
					echo "<label>infantes:</label>";
					echo "<input type='number' name='infantes' min='0' max='9'>";
				echo "</div>";
				//<button type="submit" class="btn btn-success buscar">BUSCAR</button>
				echo "<button type='submit' class='btn btn-success botonRegistra'>Continuar</button>";
				echo "</form>";
			}elseif ($control=="tomaDatos") {
				/*echo "$adultos <br>";
				echo "$niños <br>";
				echo "$infantes <br>";
				echo "$totalV <br>";*/
				//session_start();
				//ejemplo: 727,AGUASCALIENTES,CHIAPAS,2016-12-08,11:00:00,1250.00
				$_SESSION["totalV"]=$totalV;
				if($_SESSION["dataIDA"]){
					$notaIDA=explode(",", $_SESSION["dataIDA"]);
					if($_SESSION["dataREG"]!="NULL"){
						$notaREG=explode(",", $_SESSION["dataREG"]);
						$ok="OK";
					}else{
						$ok="NEL";
					}
				}
				echo "<label class='mensaje'>Quienes y cuantos prru...</label>";
				echo "<input id='mostrar-modal' name='modal' type='radio'/>";
				echo "<label for='mostrar-modal'>Ver nota</label>";
				echo "<input id='cerrar-modal' name='modal' type='radio'/>";
				echo "<label for='cerrar-modal'> X </label>";
				echo "<div id='modal'>";
					echo "<p>";
						echo "<label>tu nota prro!</label>";//ajustar
						echo "vuelo de ida: $notaIDA[0]<br>";
						echo "$notaIDA[1]<br>";
						echo "$notaIDA[2]<br>";
						echo "hora de salida: $notaIDA[4]<br>";
						echo "--------------------------------<br>";
						echo "Precio: $ $notaIDA[5]<br>";
						echo "-<br>";
						if($ok=="OK"){
							echo "vuelo de vuelta: $notaREG[0]<br>";
							echo "$notaREG[1]<br>";
							echo "$notaREG[2]<br>";
							echo "$hora de salida: $notaREG[4]<br>";
							echo "--------------------------------<br>";
							echo "Precio: $ $notaREG[5]<br>";
							echo "--------------------------------<br>";
							$prruTotal=($notaIDA[5]+$notaREG[5])*$totalV;
							echo "TOTAL: $ $prruTotal<br>";
						}elseif($ok=="NEL"){
							echo "--------------------------------<br>";
							$prruTotal=($notaIDA[5])*$totalV;
							echo "TOTAL: $ $prruTotal<br>";
						}
					echo "</p>";
				echo "</div>";
				echo "<section class='who'>";
				echo "<form class='datosViajero' method='post' action='registroGente.php'>";
					for ($i=0; $i < $totalV; $i++) { 
						$j=$i+1;
						echo "<span>Viajero $j</span>";
							echo "<div class='whoDiv'>";
								echo "<label class='etiqueta'>nombre</label>";
								echo "<input type='text' name='nombre$i' id='$nombre' required>";
							echo "</div>";
							echo "<div class='whoDiv'>";
								echo "<label class='etiqueta'>apellidos</label>";
								echo "<input type='text' name='apellidos$i' id='$apellidos' required>";
							echo "</div>";
							echo "<div class='whoDiv'>";
								echo "<label class='etiqueta'>fecha de nacimiento</label>";
								echo "<input type='date' name='nacimiento$i' id='$nacimiento' required>";
							echo "</div>";
							echo "<div class='whoDiv'>";
								echo "<label class='etiqueta'>correo electronico</label>";
								echo "<input type='email' name='email$i' id='$email' required>";
							echo "</div>";
							echo "<div class='whoDiv'>";
								echo "<label class='etiqueta'>telefono</label>";
								echo "<input type='tel' name='telefono$i' id='$telefono' required>";
							echo "</div>";
							echo "<div class='sexoOak'>";
								echo "<img src='../images/chicoChica.png' class='oak'>";
								echo "<div class='inputSexo'>";
									echo "<label class='radio-inline'>";
        							echo "<input type='radio' name='sexo$i' id='$sexo' value='F' checked='checked'>";
	        						echo "Chica";
	        						echo "</label>";
	        						echo "<label class='radio-inline'>";
	        						echo "<input type='radio' name='sexo$i' id='$sexo' value='M'>";
	        						echo "Chico";
	        						echo "</label>";
								echo "</div>";
							echo "</div>";
					}
					echo "<label class='mensaje'>Datos del Contacto</label>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Nombre</label>";
						echo "<input type='text' name='nombreC' id='nombreC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Apellidos</label>";
						echo "<input type='text' name='apellidosC' id='apellidosC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Direccion</label>";
						echo "<input type='text' name='direccionC' id='direccionC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Ciudad</label>";
						echo "<input type='text' name='ciudadC' id='ciudadC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Estado</label>";
						echo "<input type='text' name='estadoC' id='estadoC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Codigo postal</label>";
						echo "<input type='text' name='CPC' id='CPC' maxlenght='5' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Correo electronico</label>";
						echo "<input type='email' name='emailC' id='emailC' required>";
					echo "</div>";
					echo "<div class='whoDiv'>";
						echo "<label class='etiqueta'>Telefono</label>";
						echo "<input type='text' name='telefonoC' id='telefonoC' required>";
				echo "</div>";
				echo "<button type='submit' class='btn btn-success botonGrande'>Continuar</button>";
				echo "</form>";
				echo "</section>";
			} 
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