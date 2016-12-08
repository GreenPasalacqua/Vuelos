<?php
	/*****************************/
    $host="localhost";
    $user="root";
    $contraseña="315721";
    $dataBase="Proyecto";
    /*****************************/ 
    //echo "sdgvadf<br>";
    session_start();
    $cuantos=$_SESSION["totalV"];

    //numero del vuelo de ida
    $numIda=$_SESSION["numeroIDA"];
    //echo "$numIda<br>";
    if($_SESSION["numeroREG"]!="NULL"){
        //numero de vuelo de regreso, si que es que es redondo
        $numReg=$_SESSION["numeroREG"];
        //echo "$numReg<br>";
    }

    for ($i=0; $i < $cuantos; $i++) { 
        if(isset($_POST["nombre$i"])){
                $nombre[$i]=$_POST["nombre$i"];
                //echo "$nombre[$i]<br>";
                if(isset($_POST["apellidos$i"])){
                    $apellido[$i]=$_POST["apellidos$i"];
                    //echo "$apellido[$i]<br>";
                    if(isset($_POST["nacimiento$i"])){
                        $fechaNaci[$i]=$_POST["nacimiento$i"];
                        //echo "$fechaNaci[$i]<br>";
                        if(isset($_POST["email$i"])){
                            $correo[$i]=$_POST["email$i"];
                            //echo "$correo[$i]<br>";
                            if(isset($_POST["telefono$i"])){
                                $telefono[$i]=$_POST["telefono$i"];
                                //echo "$telefono[$i]<br>";
                                if(isset($_POST["sexo$i"])){
                                    if($_POST["sexo$i"]=="F"){
                                        $sexo[$i]="F";
                                        //echo "$sexo[$i]<br>";
                                    }else{
                                        $sexo[$i]="M";
                                        //echo "$sexo[$i]<br>";
                                    }
                                    $registroViajeros[$i]=$nombre[$i].",".$apellido[$i];
                                    $viajerosINFO[$i]=$nombre[$i].",".$apellido[$i].",".$fechaNaci[$i].",".$correo[$i].",".$telefono[$i].",".$sexo[$i];
                                    //echo "$viajerosINFO[$i]<br>";
                                }
                            }
                        }
                    }
                }
            }else{
            	echo "en algo se chingo de nuevo!<br>";
            }
        }

	/********************registrar a los viajeros en la BD********************/
    $laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
    if($laConexion){
        if($_SESSION["numeroREG"]=="NULL"){
            for ($i=0; $i < $cuantos; $i++) { 
                $nuevoViajero="INSERT INTO Viajero (nombre,apellido,correo,nacimiento,genero,telefono,idVuelo) VALUES ('$nombre[$i]','$apellido[$i]','$correo[$i]','$fechaNaci[$i]','$sexo[$i]','$telefono[$i]','$numIda')";
                $altaViajero=mysqli_query($laConexion,$nuevoViajero);
                if($altaViajero){
                    echo "HECHO... $nombre[$i]<br>";
                }else{
                    echo "aqui trono algo<br>";
                }
            }
        }elseif($_SESSION["numeroREG"]!="NULL"){
            for ($i=0; $i < $cuantos; $i++) { 
                $nuevoViajero="INSERT INTO Viajero (nombre,apellido,correo,nacimiento,genero,telefono,idVuelo,idVuelo2) VALUES ('$nombre[$i]','$apellido[$i]','$correo[$i]','$fechaNaci[$i]','$sexo[$i]','$telefono[$i]','$numIda','$numReg')";
                $altaViajero=mysqli_query($laConexion,$nuevoViajero);
                if($altaViajero){
                    echo "HECHO... $nombre[$i]<br>";
                }else{
                    echo "aqui trono algo<br>";
                }
            }
        }
    }
    /*************************************************************************/

        $_SESSION["listaViajeros"]=$registroViajeros;
        $_SESSION["viajerosINFO"]=$viajerosINFO;
        //registro de los viajero en sesion//
        echo "salio<br>";
        if(isset($_POST["nombreC"])){
        	$nombreC=$_POST["nombreC"];
        	$apellidoC=$_POST["apellidosC"];
        	$contacto=$nombreC."_".$apellidoC;
        	$_SESSION["contacto"]=$contacto;
        	$direccionC=$_POST["direccionC"];
	        $ciudadC=$_POST["ciudadC"];
	        $estadoC=$_POST["estadoC"];
	        $postalC=$_POST["CPC"];
	        $correoC=$_POST["emailC"];
	        $telefonoC=$_POST["telefonoC"];
	        echo "$contacto<br>";
	        echo "$direccionC<br>";
	        echo "$ciudadC<br>";
	        echo "$estadoC<br>";
	        echo "$postalC<br>";
	        echo "$correoC<br>";
	        echo "$telefonoC";
        }else{
        	echo "revisar contacto<br>";
        }

    /**********************registra al contacto en la BD**********************/
    $laConexion=mysqli_connect($host,$user,$contraseña,$dataBase);
    if($laConexion){
        $nuevoContacto="INSERT INTO Contacto (nombreApellido,direccion,ciudad,estado,CP,email,telefono,idVuelo) VALUES ('$contacto','$direccionC','$ciudadC','$estadoC','$postalC','$correoC','$telefonoC','$numIda')";
        $altaContacto=mysqli_query($laConexion,$nuevoContacto);
        if($altaContacto){
            echo "HECHO contacto: $contacto<br>";
        }else{
            echo "Oh! no!! algo salio mal en contacto<br>";
        }
    }
    /*************************************************************************/

    //----------------------------------------------//
			    if(isset($_SESSION['iteracionesAsientos'])){
			        $_SESSION['iteracionesAsientos']=null;
			    }
			    if(isset($_SESSION['vectorRegistroAsientos'])){
			        $_SESSION['vectorRegistroAsientos']=null;
			    }
			    
			    //----------------------------------------------//
        header("Location: ../vuelos/asientos.php");
        exit(0);
?>
