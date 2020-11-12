<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

// Traemos los modulos
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
    echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles/listar'."' </script>";

$modulos = $data["Detalles"];

// Traemos el perfil

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/perfiles/".$id,
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
    echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles/listar'."' </script>";
$perfil = $data["Detalles"][0];
$permisos = $data["permisos"];

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // TODO: Verificar si dejo todos los checks en blanco...!
    if (empty($_POST["modulos"]))
	echo "<script> window.alert('Por favor seleccione algún módulo');window.location.href='".base_url().'/perfiles/listar'."' </script>";

    // Actualizamos el nombre del perfil de usuario
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/perfiles/".$_POST["idPerfil"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS =>
            "perfil=".$_POST["perfil"].
			    "&id_cliente=1",
        CURLOPT_HTTPHEADER => array(
	    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ=="
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];
    if ($data["Estado"] != 200)
	echo "<script> window.alert('".$mensaje."');window.location.href='".base_url().'/perfiles/listar'."' </script>";

    // Actualizamos los permisos
    // TODO: esta implementacion solo sirve para agregar mas permisos mas no para quitarlos
    // Filtramos los modulos, si hay algun modulo nuevo seleccionado lo guardamos
    $crear = true;
    foreach ($_POST["modulos"] as $id_modulo)
    {
	foreach ($permisos as $permiso)
	{
	    if ($id_modulo == $permiso["id_modulo"])
	    {
		$crear = false;
		break;
	    }
	    else
	    {
		$crear = true;
	    }
	}
	if ($crear == true)
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
		    "id_perfil=".$_POST["idPerfil"].
				    "&id_modulo=".$id_modulo.
				    "&id_cliente=1",
		CURLOPT_HTTPHEADER => array(
		    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ=="
		),
	    ));

	    $response = curl_exec($curl);
	    curl_close($curl);
	}
    }

    echo "<script> window.alert('Perfil actualizado');window.location.href='".base_url().'/perfiles/listar'."' </script>";
}

?>

<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar perfil</h6>
        </div>
        <div class="card-body">
	    <div class="widget-content" >

		<form method="post" class="needs-validation" novalidate>
		    <div class="form-group">
			<label for="perfil">Nombre del perfil</label>
			<input type="hidden" name="idPerfil" value="<?= $perfil["idPerfil"]; ?>">
			<input type="text" value="<?= $perfil["perfil"]; ?>" class="form-control" name="perfil" id="perfil" required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Por favor rellene este campo
			</div>
		    </div>

		    <label> Permisos del perfil de usuario </label>

		    <div class="container row">
			<?php foreach ($modulos as $modulo):
			if (is_null($modulo["id_moduloPadre"])) { $listo = false;
			    foreach ($permisos as $permiso) {
				if ($permiso["id_modulo"] == $modulo["idModulo"]) {
			?>
			    <div class="col">
				<div class="form-check form-check-inline">
				    <input class="form-check-input ml-5" type="checkbox" name="modulos[]" value="<?= $modulo["idModulo"];?>" id="modulosP" checked>
				    <label class="form-check-label" for="modulosP">
					<?= $modulo["modulo"]; ?>
				    </label>
				</div>
			    </div>
			    <?php $listo = true; } }
			    if ($listo == true)
			    {
				continue;
			    }
			    
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
				    $listo = false;
				    if ($hijo["id_moduloPadre"] == $padre["idModulo"])
				    {
					foreach ($permisos as $permiso) {
					    if ($permiso["id_modulo"] == $hijo["idModulo"]) {
						$listo = true;
						
				?>
				    <div class="form-check">
					<input class="form-check-input" type="checkbox" name="modulos[]" value="<?= $hijo["idModulo"];?>" id="modulosH" checked>
					<label class="form-check-label" for="modulosH">
					    <?= $hijo["modulo"]; ?>
					</label>
				    </div>
				    <?php
				    
				    }
				    }
				    if ($listo == true)
					continue;
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

                    <button type="submit" class="btn btn-primary"> Aceptar </button>
		    <a href="<?= base_url().'/perfiles/listar'; ?>" class="btn btn-danger"> Cancelar </a>
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
