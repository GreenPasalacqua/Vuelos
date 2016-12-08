<!DOCTYPE html>
<html lang="en" class="fondo">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EL PERRO VOLADOR</title>
 
 	<link rel="stylesheet" type="text/css" href="css/estilos2.css">
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" type="text/css" href="bootstrap.css">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
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
        <li role="presentation" class="active"><a href="#">Home</a></li>
        <li role="presentation"><a href="#">Check-in</a></li>
        <li role="presentation"><a href="#">No se que poner aqui</a></li>
      </ul>
    </section>
  <section class="centro">
  <section class="carrusel">
  	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="images/dest1.jpg">
          <div class="carousel-caption">
          <h3>Aqui podemos poner algo</h3>
          </div>
		    </div>

		    <div class="item">
		      <img src="images/dest2.jpg">
          <div class="carousel-caption">
          <h3>aqui tambien</h3>
          </div>
		    </div>

		    <div class="item">
		      <img src="images/dest3.jpg">
          <div class="carousel-caption">
          <h3>aqui tambien</h3>
          </div>
		    </div>

        <div class="item">
          <img src="images/dest4.jpg">
          <div class="carousel-caption">
          <h3>aqui tambien</h3>
          </div>
        </div>

        <div class="item">
          <img src="images/dest5.jpg">
          <div class="carousel-caption">
          <h3>y aqui!</h3>
          </div>
        </div>

		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
	</div>
  </section>
  <section class="formulario">
  <form method="post" action="pages/idaVuelo.php">
  <section class="cajaDestinos">
    <section>
      <div class="destinos">
        <label>de donde vienes</label>
              <select name="origen" class="selectDestinos">
                <option>aguascalientes</option>
                <option>chiapas</option>
                <option>puebla</option>
                <option>df</option>
                <option>yucatan</option>
                <option>zacatecas</option>
                <option>tamaulipas</option>
                <option>nayarit</option>
                <option>jalisco</option>
                <option>nuevo_leon</option>
                <option>sinaloa</option>
                <option>veracruz</option>
              </select> 
      </div>
      <div class="destinos">
        <label>a donde vas</label>
              <select name="destino" class="selectDestinos">
                <option>aguascalientes</option>
                <option>chiapas</option>
                <option>puebla</option>
                <option>df</option>
                <option>yucatan</option>
                <option>zacatecas</option>
                <option>tamaulipas</option>
                <option>nayarit</option>
                <option>jalisco</option>
                <option>nuevo_leon</option>
                <option>sinaloa</option>
                <option>veracruz</option>
              </select>
      </div>
    </section>
    <section>
      <div class="destinos">
        <label>fecha de partida</label>
            <input type="date" name="fecha-salida" required> 
      </div>
      <div class="destinos tipoVuelo">
        <label class="radio-inline">
        <input type="radio" name="tipo" id="tipo" value='sencillo' checked="checked">Sencillo</label>
        <label class="radio-inline">
        <input type="radio" name="tipo" id="tipo" value='redondo'>Redondo</label>
      </div>
    </section>
    <div>
      <button type="submit" class="btn btn-success buscar">BUSCAR</button>
    </div>
  </section>
  </form>
  </section>
  <footer>
    <section>
      <span>universidad autonoma de aguascalientes UAA | isc | 5°c</span>
      <span>oscar antonio hernández mojica</span>
      <span>luis daniel reyna pérez</span>
    </section>
  </footer>
  <script src="js/bootstrap.min.js"></script>
  </body>
</html>

