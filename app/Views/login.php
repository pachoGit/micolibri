<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    session_start();

    $_SESSION["auth"] = "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ==";
    $_SESSION["cliente"] = 5;

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>
            "correo=".$_POST["correo"].
			    "&contra=".$_POST["contra"].
			    "&id_cliente=".$_SESSION["cliente"],
        CURLOPT_HTTPHEADER => array(
	    $_SESSION["auth"], "Cliente:".$_SESSION["cliente"],
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($data["Estado"] != 200)
    {
	$mensaje = $data["Detalles"];
	session_destroy();
	echo "<script>alert('Correo o contraseña incorrectos');window.location.href = '".base_url()."';</script>";
    }
    /*
    if (!isset($data["Detalles"][0]))
	echo "<script>alert('Correo o contraseña incorrectos');window.location.href = '".base_url()."';</script>";
    */

    $usuario = $data["Detalles"][0];

    $_SESSION["idUsuario"] = $usuario["idUsuario"];
    $_SESSION["nombres"] = $usuario["nombres"];
    $_SESSION["apellidos"] = $usuario["apellidos"];
    $_SESSION["id_perfil"] = $usuario["id_perfil"];
    $_SESSION["correo"] = $usuario["correo"];

    // Guardamos la sesion
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/sesiones",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>
            "id_usuario=".$usuario["idUsuario"].
			    "&id_cliente=".$_SESSION["cliente"],
        CURLOPT_HTTPHEADER => array(
	    $_SESSION["auth"],
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    if ($data["Estado"] != 200)
	echo "<script> alert('Algo ocurrió mal al registrar la sesion'); </script>";

    $_SESSION["idsesion"] = $data["idsesion"];

    // Aqui hay que traer los modulos y permisos del usuario  y guardarlo en una parte
    // de $_SESSION

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/perfiles/".$usuario["id_perfil"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
	    $_SESSION["auth"], "Cliente:".$_SESSION["cliente"]
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $perfil = json_decode($response, true);

    if ($data["Estado"] != 200)
	echo "<script> alert('Algo ocurrió mal al registrar la sesion'); </script>";

    $_SESSION["permisos"] = $perfil["permisos"];

    //var_dump($_SESSION["permisos"]);die;
    echo "<script> window.location.href='".base_url().'/home/principal'."'; </script>";

}

?>

<!doctype html>
<html lang="en">
    <head>
	<meta http-equiv="Content-type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v4.1.1">
	<title>Mi Colibri Software</title>

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url().'/public/bootstrap-4.5.2/css/bootstrap.min.css';?>" rel="stylesheet">
	
	<style>
	 .bd-placeholder-img {
             font-size: 1.125rem;
             text-anchor: middle;
             -webkit-user-select: none;
             -moz-user-select: none;
             -ms-user-select: none;
             user-select: none;
	 }

	 @media (min-width: 768px) {
             .bd-placeholder-img-lg {
		 font-size: 3.5rem;
             }
	 }
	</style>
	<!-- Custom styles for this template -->
	<link href="<?php echo base_url().'/public/ayudas/floating-labels.css';?>" rel="stylesheet">
    </head>
    <body>

	<form  method="post" class="form-signin">
	    <div class="text-center mb-4">
		<img class="mb-4" src="<?php echo base_url().'/public/media/colibri.png';?>" alt="" width="72" height="72">
		<h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
	    </div>

	    <div class="form-label-group">
		<input type="email" id="correo" name="correo" class="form-control" required autofocus>
		<label for="inputEmail">Correo electr&oacute;nico</label>
	    </div>

	    <div class="form-label-group">
		<input type="password" id="contra" name="contra" class="form-control"  required autofocus>
		<label for="nombres">Ingrese su contraseña</label>
	    </div>

	    <button class="btn btn-lg btn-primary btn-block" type="submit">Aceptar</button>
	    <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2020</p>
	</form>

    </body>
</html>
