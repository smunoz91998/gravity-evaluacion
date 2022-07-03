<?php 
	session_start();
	error_reporting(0);
	$varsesion=$_SESSION['usuario'];
	if($varsesion==null || $varsesion=''){
        header("Location:index.php");
	}else{
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
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gravity  | Upload CV</title>
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
                <a href="upload.php" class="activo">Cargar CV</a>
                <a href="download.php">Descargar CV</a>                
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
            <h1>Subir CV</h1>
            <div class="icono"></div>

            <form id="form">
                <input type="file" name="file" id="cv" value="cv" accept=".pdf"><br>
                <button type="submit" id="submit1" name="submit1" class="button">Subir</button><br>
            </form>
        </div>
    </div>



    <div class="bottom-side">
        <div class="banner-1"></div>
        <div class="banner-2">
            <p>Debe ser únicamente en extensión .pdf y no mayor a 5MB.</p>  
        </div>
        <div class="banner-3"></div>
    </div>



</div>
</body>
</html>


<script>
	$(document).ready(function (){

        $('#form').on('submit', function(e) {
            e.preventDefault();

            const files_upload = document.getElementById('cv');
            if (files_upload.files.length  == 1 ) {
                const fname = files_upload.files.item(0).name;
                const fsize = Math.round(( files_upload.files.item(0).size / 1024));
                const fext = fname.split('.').pop();

                if(fext == "pdf" || fext == "PDF" ){
                    if (fsize <= 5120) {

                        var form=document.getElementById('form');
                        var fdata=new FormData(this); 
                        fdata.append('funcion', "upload");
                        fdata.append('formulario', form);

                        $.ajax({
                            type: "POST",
                            url: 'functions.php',
                            data: fdata,
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(result){                
                                if(result == 1){                    
                                    swal({
                                        title: 'Carga con éxito',
                                        text: 'El archivo se subio de forma exitosa.',
                                        icon: 'success'
                                    });
                                }else{
                                    swal({ 
                                        title: 'Error',
                                        text: 'No se pudo subir el PDF, intente mas tarde.',
                                        icon: 'error',
                                        button: 'Cerrar'
                                    });
                                }

                                console.log(result);
                                $("input[type='file']").val('');
                            }
                        });

                    }else{
                        swal({ 
                            title: 'Error',
                            text: 'Solo se permiten archivos PDF de 5MB.',
                            icon: 'error',
                            button: 'Cerrar'
                        });
                        $("input[type='file']").val('');
                    }
                
                }else{
                    swal({ 
                        title: 'Error',
                        text: 'Solo se permiten archivos PDF.',
                        icon: 'error',
                        button: 'Cerrar'
                    });

                    $("input[type='file']").val('');
                }        

            

            }else if (files_upload.files.length > 1){
                swal({ 
                    title: 'Error',
                    text: 'Solo se permite un archivo.',
                    icon: 'error',
                    button: 'Cerrar'
                });
                $("input[type='file']").val('');

            }else if (files_upload.files.length == 0){
                swal({ 
                    title: 'Error',
                    text: 'No selecciono ningun archivo.',
                    icon: 'error',
                    button: 'Cerrar'
                });
                $("input[type='file']").val('');
            }

        });



    });//End jQuery  
</script>      