<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["modulos"]))
	echo "<script> window.alert('Por favor seleccione algún módulo');window.location.href='".base_url().'/perfiles/registrar'."' </script>";

    // Creamos el perfil
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/perfiles",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>
        "perfil=".$_POST["perfil"].
        "&id_cliente=1",
        CURLOPT_HTTPHEADER => array(
	    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ==",
                                    ),
                                   ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];
    if ($data["Estado"] != 200)
	echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles/registrar'."' </script>";

    /*** Registramos los permisos ***/

    // Traemos el perfil recien creado
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/perfiles",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
	    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ==",
	    "Cliente:1"
                                    ),
                                   ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];
    if ($data["Estado"] != 200)
	echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles/registrar'."' </script>";
    
    $este_perfil = ""; // Perfil recien creado
    foreach ($data["Detalles"] as $perfil)
    {
	if ($perfil["perfil"] == $_POST["perfil"])
	{
	    $este_perfil = $perfil;
	    break;
	}
    }
    // Este if nunca debe ser verdadero
    if ($este_perfil == "")
	echo "<script> window.alert('Perfil creado no encontrado');window.location.href='".base_url().'/perfiles/registrar'."' </script>";
    
    $id_perfil = $este_perfil["idPerfil"];

    // Insertamos los modulos en los permiso del perfil de usuario
    foreach ($_POST["modulos"] as $modulo)
    {
	$curl = curl_init();
	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/permisos",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
		"id_modulo=".$modulo.
				"&id_perfil=".$id_perfil.
				"&id_cliente=1",
            CURLOPT_HTTPHEADER => array(
		"Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ==",
            ),
        ));

	//$response = curl_exec($curl);
	curl_close($curl);

	//$data = json_decode($response, true);
    }
    echo "<script> window.alert('Perfil de usuario creado');window.location.href='".base_url().'/perfiles'."' </script>";
}


$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/modulos",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
      "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ==",
      "Cliente:1"
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

$mensaje = $data["Detalles"];
if ($data["Estado"] != 200)
    echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles'."' </script>";

$modulos = $data["Detalles"];

?>

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar perfil</h6>
        </div>
        <div class="card-body">
	    <div class="widget-content" >

		<form method="post" class="needs-validation" novalidate>
		    <div class="form-group">
			<label for="perfil">Nombre del perfil</label>
			<input type="text" class="form-control" name="perfil" id="perfil" required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Por favor rellene este campo
			</div>
		    </div>

		    <label> Modulos del perfil de usuario </label>
		    <div class="container row">
			<?php foreach ($modulos as $modulo):
			 if (is_null($modulo["id_moduloPadre"])) {
			?>
			    <div class="col">
				<div class="form-check form-check-inline">
				    <input class="form-check-input ml-5" type="checkbox" name="modulos[]" value="<?= $modulo["idModulo"];?>" id="modulosP">
				    <label class="form-check-label" for="modulosP">
					<?= $modulo["modulo"]; ?>
				    </label>
				</div>
			    </div>
			<?php } endforeach; ?>
		    </div>

		    <div class="container row mb-4">
			<?php
			foreach  ($modulos as $modulo) {
			    if (is_null($modulo["id_moduloPadre"])) {
				$padre = $modulo;
			?>
			    <div class="col">
				<?php 
				foreach ($modulos as $hijo)
				{
				    if ($hijo["id_moduloPadre"] == $padre["idModulo"])
				    {
				?>	
				    <div class="form-check">
					<input class="form-check-input" type="checkbox" name="modulos[]" value="<?= $hijo["idModulo"];?>" id="modulosH" >
					<label class="form-check-label" for="modulosH">
					    <?= $hijo["modulo"]; ?>
					</label>
				    </div>
				<?php
				}
				}
				?>
			    </div>
			    <?php
			    }
			    }
			    ?>

		    </div>

                    <button type="submit" class="btn btn-primary"> Registrar </button>
		    <a href="<?= base_url().'/perfiles'; ?>" class="btn btn-danger"> Cancelar </a>
		</form>

	    </div>
        </div>
    </div>
</div>


<script>
 // Example starter JavaScript for disabling form submissions if there are invalid fields
 (function() {
     'use strict';
     window.addEventListener('load', function() {
	 // Fetch all the forms we want to apply custom Bootstrap validation styles to
	 var forms = document.getElementsByClassName('needs-validation');
	 // Loop over them and prevent submission
	 var validation = Array.prototype.filter.call(forms, function(form) {
	     form.addEventListener('submit', function(event) {
		 if (form.checkValidity() === false) {
		     event.preventDefault();
		     event.stopPropagation();
		 }
		 form.classList.add('was-validated');
	     }, false);
	 });
     }, false);
 })();
</script>
