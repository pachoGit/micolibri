<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!empty($_FILES["rutaFoto"]["name"]))
    {
	$ruta = "/public/usuarios/".$_FILES["rutaFoto"]["name"];
	//$ruta2 = $_SESSION["ruta"]."usuarios/".$_FILES["rutaFoto"]["name"];
	$ruta2 = "/var/www/html/micolibri/public/usuarios/".$_FILES["rutaFoto"]["name"];
	move_uploaded_file($_FILES["rutaFoto"]["tmp_name"], $ruta2);

	$curl = curl_init();

	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/usuarios/".$_POST["idUsuario"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>
		"nombres=".$_POST["nombres"].
				"&apellidos=".$_POST["apellidos"].
				"&dni=".$_POST["dni"].
				"&sexo=".$_POST["sexo"].
				"&edad=".$_POST["edad"].
				"&rutaFoto=".$ruta.
				"&direccion=".$_POST["direccion"].
				"&correo=".$_POST["correo"].
				"&contra=".$_POST["contra"].
				"&id_perfil=".$_POST["id_perfil"].
				"&id_cliente=1".        
				"&comentario=".$_POST["comentario"],
            CURLOPT_HTTPHEADER => array(
		"Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ=="
            ),
        ));

	$response = curl_exec($curl);
	curl_close($curl);
    }
    else
    {
	$curl = curl_init();

	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/usuarios/".$_POST["idUsuario"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>
		"nombres=".$_POST["nombres"].
				"&apellidos=".$_POST["apellidos"].
				"&dni=".$_POST["dni"].
				"&sexo=".$_POST["sexo"].
				"&edad=".$_POST["edad"].
				"&direccion=".$_POST["direccion"].
				"&correo=".$_POST["correo"].
				"&contra=".$_POST["contra"].
				"&id_perfil=".$_POST["id_perfil"].
				"&id_cliente=1".        
				"&comentario=".$_POST["comentario"],
            CURLOPT_HTTPHEADER => array(
		"Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VMaHJqbVR2b2cyS0hMZ2l4b0s4YjZjcHR0dS8wZFRXOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlL3BKUmZVVlhYc1E0MW9TUURnUHUzNDB6VU42TlZSbQ=="
            ),
        ));

	$response = curl_exec($curl);
	curl_close($curl);

    }

    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];

    echo "<script> alert('".$mensaje."');window.location.href='".base_url().'/usuarios'."' </script>";
    
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/usuarios/".$id,
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

if ($data["Estado"] != 200)
    echo "<script> alert('Hubo un error al mostrar el usuario');window.location.href='".base_url().'/usuarios/listar'."' </script>";

$data = $data["Detalles"][0];

// Traemos los perfiles de usuario
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/perfiles",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
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

$perfiles = json_decode($response, true);
$perfiles = $perfiles["Detalles"];

?>


<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar usuario</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="nombres">Nombres</label>
			    <input type="hidden" name="idUsuario" value="<?= $id ?>">
			    <input type="text" name="nombres" value="<?= $data["nombres"]; ?>" class="form-control" id="nombres" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese su nombre
			    </div>
			</div>
			<div class="form-group col-md-6">
			    <label for="apellidos">Apellidos</label>
			    <input type="text" name="apellidos" class="form-control" value="<?= $data["apellidos"]; ?>" id="apellidos" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese su apellido
			    </div>
			</div>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="correo">Correo electr&oacute;nico</label>
			    <input type="email" name="correo" class="form-control" id="correo" value="<?= $data["correo"]; ?>" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un correo electr&oacute;nico valido
			    </div>
			</div>
			<div class="form-group col-md-6">
			    <label for="contra">Contrase&ntilde;a </label>
			    <input type="password" class="form-control" name="contra" id="contra" value="<?= $data["contra"]; ?>" minlength="3" required>
			    <div class="invalid-feedback">
				Rellene este campo
			    </div>
			</div>
		    </div>

		    <div class="form-group">
			<label for="inputAddress">Direcci&oacute;n</label>
			<input type="text" class="form-control" name="direccion" id="inputAddress" value="<?= $data["direccion"]; ?>" placeholder="1234 Main St" required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese algo aqu&iacute;
			</div>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-4">
			    <label for="dni">DNI</label>
			    <input type="text" class="form-control" name="dni" id="dni" readonly value="<?= $data["dni"]; ?>"  mixlength="8" maxlength="8">
			    <div class="invalid-feedback">
				Ingrese solo 8 n&uacute;meros
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="edad">Edad</label>
			    <input type="number" class="form-control" value="<?= $data["edad"]; ?>" name="edad" id="edad" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un n&uacute;mero natural
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="id_perfil">Seleccione un perfil</label>
			    <select id="id_perfil" name="id_perfil" class="form-control" required>
				<?php foreach ($perfiles as $perfil): ?>
				    <option value="<?= $perfil["idPerfil"]?>" <?php if ($perfil["perfil"] == $data["perfil"]) { echo "selected"; }?> > <?= $perfil["perfil"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
		    </div>
		    <div class="form-group">
			<label for="fechaCreacion">Fecha de creaci&oacute;n</label>
			<input type="date" class="form-control" name="fechaCreacion" id="fechaCreacion" value="<?= $data["fechaCreacion"]; ?>"  readonly>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese algo aqu&iacute;
			</div>
		    </div>

		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" type="radio" name="sexo" id="masculino" <?php if ($data["sexo"] == "M") {echo "checked";} ?> value="M" required>
			<label class="form-check-label" for="masculino">
			    Masculino
			</label>
		    </div>
		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" type="radio" name="sexo" id="femenino" <?php if ($data["sexo"] == "F") {echo "checked";} ?> value="F" >
			<label class="form-check-label" for="femenino">
			    Femenino
			</label>
		    </div>

		    <div class="form-group">
			     <label for="rutaFoto">Escoja un foto</label>
			     <input type="file" name="rutaFoto"  class="form-control-file" id="rutaFoto">
		    </div>

		    <div class="form-group">
			<label for="comentario">Comentario</label>
			<textarea type="text" class="form-control" name="comentario" value="<?= $data["comentario"]; ?>" id="comentario"> <?= $data["comentario"]; ?> </textarea>
		    </div>
                    <button type="submit" class="btn btn-primary"> Aceptar </button>
		    <a href="<?= base_url().'/usuarios'; ?>" class="btn btn-danger"> Cancelar </a>
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

