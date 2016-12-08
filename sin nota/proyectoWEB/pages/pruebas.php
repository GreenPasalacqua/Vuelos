<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="../css/modales.css">
<?php 
	session_start();
	$cuantos=$_SESSION["totalV"];
	for ($i=0; $i < $cuantos; $i++) { 
		$nombre="N".$i;
		if(isset($_POST["N$i"])){
			echo "funciona<br>";
			$caca=$_POST["N$i"];
			echo "$caca<br>";
		}
	}
?>
<head>
	<title>este documento es solo para prubas del codigo para el proyecto de Al</title>
</head>
<body>
<section>
	<input id="mostrar-modal" name="modal" type="radio" /> 
  	<label for="mostrar-modal"> Ver modal </label>
  	<input id="cerrar-modal" name="modal" type="radio" /> 
	<label for="cerrar-modal"> X </label> 
	<div id="modal">
  		<p> 
  			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nostrum nihil id commodi ipsa vitae dolore molestiae minus enim. Nulla ut recusandae nemo quam autem minus totam impedit, quod accusamus optio?
  		</p>
	</div>
	
</section>
</body>
</html>