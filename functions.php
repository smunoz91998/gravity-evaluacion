<?php
    if($_POST){
        session_start();

        if ($_POST['funcion']=="signin") {
            $signin_email=$_POST['signin_email'];
            $signin_password=$_POST['signin_password'];

            
            if(!empty($signin_email) && preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$signin_email)
                && !empty($signin_password) && preg_match("/^[a-zA-Z0-9\-_$.]*$/",$signin_password)){
                    

                $url = "https://candidates-exam.herokuapp.com/api/v1/auth/login";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                "Accept: application/json",
                "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


                $login_data = array(
                    "email" => $signin_email,
                    "password" => $signin_password
                );
                $data_login = json_encode($login_data);

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_login);

                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($resp, true);
                
                if($json['tipo'] == 1){
                    $_SESSION['usuario'] = $json['usuario'];
                    $_SESSION['url'] = $json['url'];
                    $_SESSION['token'] = $json['token'];
                    $_SESSION['tipo'] = $json['tipo'];
                }

                echo $json['tipo'];
            }else{
                echo false;
            }    

        }//End function signIn




        else if ($_POST['funcion']=="signup") {
            $signup_nombre=$_POST['signup_nombre'];
            $signup_email=$_POST['signup_email'];
            $signup_password=$_POST['signup_password'];
            $signup_conpassword=$_POST['signup_conpassword'];


            if( !empty($signup_nombre) && preg_match("/^[a-zA-Z ]*$/",$signup_nombre) 
                && !empty($signup_email) && preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$signup_email)
                && !empty($signup_password) && preg_match("/^[a-zA-Z0-9\-_$.]*$/",$signup_password)
                && !empty($signup_conpassword) && preg_match("/^[a-zA-Z0-9\-_$.]*$/",$signup_conpassword) ){


                $url = "https://candidates-exam.herokuapp.com/api/v1/usuarios";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                "Accept: application/json",
                "Content-Type: application/json",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $register_data = array(
                    "nombre" => $signup_nombre,
                    "email" => $signup_email,
                    "password" => $signup_password,
                    "password_confirmation" => $signup_conpassword
                );
                $data_register = json_encode($register_data);
        
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_register);

                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($resp, true);
                
                echo $json['estado'];
            
            }else{
                echo false;
            }

        }//End function signUp




        else if ($_POST['funcion']=="upload") {
            $targetfolder = "./cv_upload/";
            $tmpfile = $_FILES['file']['tmp_name'];
            $filename = basename($_FILES['file']['name']);
            $targetfolder = $targetfolder."".$filename ;

            $file_type=$_FILES['file']['type'];

            if ($file_type=="application/pdf") {
                if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder)){

                    $url = "https://candidates-exam.herokuapp.com/api/v1/usuarios/".$_SESSION['url']."/cargar_cv";

                    
                    $pdf_file = new CURLFile($targetfolder,'application/pdf');                   
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    $headers = array(
                    "Accept: application/json",
                    "Content-Type: multipart/form-data",
                    "Authorization: Bearer ".$_SESSION['token']
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


                    $login_data = array(
                        "curriculum" => $pdf_file
                    );

                    curl_setopt($curl, CURLOPT_POSTFIELDS, $login_data);

                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                    $resp = curl_exec($curl);
                    curl_close($curl);

                    $json = json_decode($resp, true);                    
                    $_SESSION['url_cv'] = $json['url_cv'];
                    
                    $resp = true;                    
                    

                }else {
                    $resp = false;
                }
            }else {
                $resp = false;
            }

            echo $resp;
        }//End function upload

        
    }else{
        header("Location:index.php");
    }    
?>