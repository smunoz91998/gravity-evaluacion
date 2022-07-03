<?php 
	session_start();
	error_reporting(0);
	$varsesion=$_SESSION['usuario'];
	if($varsesion==null || $varsesion=''){
        header("Location:index.php");
	}else{
        //Peticion de nombre
        $url = "https://candidates-exam.herokuapp.com/api/v1/usuarios/";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array( 
            "Accept: application/json",   
            "Authorization: Bearer ".$_SESSION['token']
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $json_resp = json_decode($resp, true);
        $_SESSION['nombre'] = $json_resp['nombre'];



        //Peticion de pdf
        $url = "https://candidates-exam.herokuapp.com/api/v1/usuarios/mostrar_cv";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array( 
            "Accept: application/json",   
            "Authorization: Bearer ".$_SESSION['token']
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $json_resp = json_decode($resp, true);
        $_SESSION['url_cv'] = $json_resp['url'];



    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gravity  | Download CV</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- style -->
    <link rel="stylesheet" href="./css/upload.css">

    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/jquery-3.4.1.min.js"></script>

    <!-- favicon -->
    <link rel="icon" href="./img/favicon.ico">

</head>
<body>
<div class="container">   


    <div class="top-side">
        <div class="menu">
            <div class="botones">
                <a href="upload.php">Cargar CV</a>
                <a href="download.php" class="activo">Descargar CV</a>                
            </div>

            <div class="logout">
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>

        <div class="encabezado">
            <h1>Bienvenido a tu espacio</h1>

            <label><?php echo $_SESSION['nombre']; ?></label>
        </div>


        <div class="banner-1">
            <h1>Descargar CV</h1>
            <div class="icono"></div><br>

            
            <a href="<?php echo $_SESSION['url_cv'] ?>" target="_blank" class="button">Descargar</a><br>
            
        </div>
    </div>



    <div class="bottom-side">
        <div class="banner-1"></div>
        <div class="banner-2">
            <p>Soluciones tecnologicas. Desarrollo de paginas web, <br>
            CRM, plataformas estudiantiles.</p>  
        </div>
        <div class="banner-3"></div>
    </div>


</div>
</body>
</html>