<?php 
	session_start();
	error_reporting(0);
	$varsesion=$_SESSION['usuario'];
	if($varsesion==null || $varsesion=''){

	}else{
		header("Location:upload.php");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gravity | Iniciar Sesion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- style -->
    <link rel="stylesheet" href="./css/index.css">


    <!-- javascript -->
    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/jquery-3.4.1.min.js"></script>

    <!-- favicon -->
    <link rel="icon" href="./img/favicon.ico">

</head>
<body>
    <div class="container">   


        <div class="left-side">
            <div class="banner-1"></div>

            <div class="banner-2">

                <div class="slideshow-container">
                    <div class="mySlides fade">
                        <img src="img/Imagen1.png" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                        <img src="img/Imagen2.png" style="width:100%">
                    </div>

                    <div class="mySlides fade">
                        <img src="img/Imagen3.png" style="width:100%">
                    </div>
                </div>
                <br>

                <div style="text-align:center">
                    <span class="dot"></span> 
                    <span class="dot"></span> 
                    <span class="dot"></span> 
                </div>



                <h1>Gravity</h1>
                <p>
                    Soluciones tecnologicas. Desarrollo de paginas web,<br> CRM, plataformas estudiantiles.
                </p>
            </div>

            <div class="banner-3"></div>
        </div>


        <div class="right-side">
            <div class="encabezado">
                <h1>Bienvenido a</h1>
                <label>Gravity</label>
            </div>
            

            <div class="tab">
                <button class="tablinks" onclick="openPage('Inicio', this, 'white')"  id="defaultOpen">Iniciar Sesion</button>
                <button class="tablinks" onclick="openPage('Registro', this, 'white')"  id="btn-tab2">Registro</button>
            </div>

            <div id="Inicio" class="tabcontent">
                <div class="signin">
                    <div>
                        <h2>email</h2>
                        <input type="text" name="signin_email" id="signin_email" placeholder="email"  pattern="[a-zA-Z0-9@._-]{5,80}" 
                        onkeypress="return /[a-zA-Z0-9@._-]/i.test(event.key)" minlength="5" maxlength="80"
					    autocomplete="off" required>
                    </div>     
                    
                    <div>
                        <h2>Password</h2>
                        <input type="password" name="signin_password" id="signin_password" placeholder="password"  pattern="[a-zA-Z0-9$._-]{5,80}" 
                        onkeypress="return /[a-zA-Z0-9$._-]/i.test(event.key)" minlength="5" maxlength="80"
					    autocomplete="off" required>
                    </div> 

                    <button type="submit" class="button"id="signin_button">Iniciar sesión</button>
                </div>                
            </div>


            <div id="Registro" class="tabcontent">
                <div class="signup">
                    <div>
                        <h2>Nombre</h2>
                        <input type="text" name="signup_nombre" id="signup_nombre" placeholder="nombre"  pattern="[a-zA-ZÀ-ÿñÑ ]{5,80}" 
                        onkeypress="return /[a-zA-ZÀ-ÿñÑ ]/i.test(event.key)" minlength="5" maxlength="80"
					autocomplete="off" required>
                    </div> 

                    <div>
                        <h2>email</h2>
                        <input type="text" name="signup_email" id="signup_email" placeholder="email"pattern="[a-zA-Z0-9@._-]{5,80}" 
                        onkeypress="return /[a-zA-Z0-9@._-]/i.test(event.key)" minlength="5" maxlength="80"
					    autocomplete="off" required>
                    </div> 

                    <div>
                        <h2>Password</h2>
                        <input type="password" name="signup_password" id="signup_password" placeholder="password"  pattern="[a-zA-Z0-9$._-]{5,80}" 
                        onkeypress="return /[a-zA-Z0-9$._-]/i.test(event.key)" minlength="5" maxlength="80"
					    autocomplete="off" required>
                    </div> 

                    <div>
                        <h2>Confirm Password</h2>
                        <input type="password" name="signup_conpassword" id="signup_conpassword" placeholder="confirm password"  pattern="[a-zA-Z0-9$._-]{5,80}" 
                        onkeypress="return /[a-zA-Z0-9$._-]/i.test(event.key)" minlength="5" maxlength="80"
					    autocomplete="off" required>
                    </div> 

                    <button type="submit" class="button"id="signup_button">Registrarse</button>
                </div>     
            </div>
        </div>


    </div>
</body>
</html>


<script>
	$(document).ready(function (){

	//******************* Inicio de sesion **********************	
		$("#signin_password").on('keyup', function (e) {
			if (e.key === 'Enter' || e.keyCode === 13) {
				signIn();
			}
		});

		$('#signin_button').click(function(){
			signIn();
        });

		function signIn() {
			var signin_email = $("#signin_email").val();
			var signin_password = $("#signin_password").val();
             
			if(signin_email && signin_password){
                $.ajax({
                    url: 'functions.php',
                    type: 'POST',
                    data: { "funcion": "signin", "signin_email": signin_email, "signin_password": signin_password},
                    success: function (response) {
                       if(response==1){
                            window.location.href = "upload.php";
                        }else{
                            swal({ 
                                title: 'Error',
                                text: 'Usuario y/o contraseña incorrecto.',
                                icon: 'error',
                                button: 'Cerrar'
                            });
                        }
                    }
                });

			}else{
				swal({ 
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos.',
                    icon: 'error',
                    button: 'Cerrar'
                });
			}
		}




        //******************* Registro **********************	
        $("#signup_conpassword").on('keyup', function (e) {
			if (e.key === 'Enter' || e.keyCode === 13) {
				signUp();
			}
		});

		$('#signup_button').click(function(){
			signUp();
        });

        function signUp() {
            var signup_nombre = $("#signup_nombre").val();
			var signup_email = $("#signup_email").val();
			var signup_password = $("#signup_password").val();
            var signup_conpassword = $("#signup_conpassword").val();

             
			if(signup_nombre && signup_email && signup_password && signup_conpassword){
                if(signup_password == signup_conpassword){
                    $.ajax({
                        url: 'functions.php',
                        type: 'POST',
                        data: { "funcion": "signup", "signup_nombre": signup_nombre, "signup_email": signup_email, "signup_password": signup_password, "signup_conpassword": signup_conpassword},
                        success: function (response) {
                            if(response==1){
                                swal({
                                    title: 'Registro con éxito',
                                    text: 'El usuario fue agregado con éxito.',
                                    icon: 'success'
                                });
                            }else{
                                swal({ 
                                    title: 'Error al insertar',
                                    text: 'Ha ocurrido un error, por favor vuelva a intentarlo.',
                                    icon: 'error',
                                    button: 'Cerrar'
                                });
                            }

                            $("#signup_nombre").val("");
                            $("#signup_email").val("");
                            $("#signup_password").val("");
                            $("#signup_conpassword").val("");
                        }
                    });

                }else{
                    swal({ 
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.',
                        icon: 'error',
                        button: 'Cerrar'
                    });
                }

			}else{
				swal({ 
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos.',
                    icon: 'error',
                    button: 'Cerrar'
                });
			}
		}

	});//End jQuery


    function openPage(pageName,elmnt,color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
                tablinks[i].style.borderBottom = "4px solid white";
            }

            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;    
            elmnt.style.borderBottom = "4px solid #26CBFF"
            
        }
        document.getElementById("defaultOpen").click();

        document.getElementById("defaultOpen").onclick = function(event) { 
            document.getElementById("defaultOpen").style.borderBottom = "4px solid #26CBFF";
            document.getElementById("btn-tab2").style.borderBottom = "4px solid white";

            document.getElementById("Inicio").style.display = "block";
            document.getElementById("Registro").style.display = "none";
        };
        document.getElementById("btn-tab2").onclick = function(event) {
            document.getElementById("defaultOpen").style.borderBottom = "4px solid white";
            document.getElementById("btn-tab2").style.borderBottom = "4px solid #26CBFF";

            document.getElementById("Registro").style.display = "block";
            document.getElementById("Inicio").style.display = "none";
        };


        let slideIndex = 0;
        showSlides();

        function showSlides() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 5000); // Change image every 2 seconds
        }

</script>