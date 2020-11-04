<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $ruta = "/public/alumnos/".$_FILES["rutaFoto"]["name"];
    //$ruta2 = $_SESSION["ruta"]."alumnos/".$_FILES["rutaFoto"]["name"];
    $ruta2 = "/var/www/html/micolibri/public/alumnos/".$_FILES["rutaFoto"]["name"];
    move_uploaded_file($_FILES["rutaFoto"]["tmp_name"], $ruta2);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/alumnos",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>
        "nombres=".$_POST["nombres"].
        "&apellidos=".$_POST["apellidos"].
        "&dni=".$_POST["dni"].
        "&sexo=".$_POST["sexo"].
        "&edad=".$_POST["edad"].
        "&rutaFoto=".$ruta.
        "&direccion=".$_POST["direccion"].
        "&correo=".$_POST["correo"].
        "&nombrePadre=".$_POST["nombrePadre"].
        "&nombreMadre=".$_POST["nombreMadre"].
        "&id_cliente=1".        
        "&comentario=".$_POST["comentario"],
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
	echo "<script> alert('".$mensaje."');window.location.href='".base_url().'/alumnos/registrar'."' </script>";
    else
	echo "<script> alert('".$mensaje."');window.location.href='".base_url().'/alumnos'."' </script>";
}

?>


<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar alumno</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form class="needs-validation" method="post" enctype="multipart/form-data" novalidate>
		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="nombres">Nombres</label>
			    <input type="text" name="nombres" class="form-control" id="nombres" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese su nombre
			    </div>
			</div>
			<div class="form-group col-md-6">
			    <label for="apellidos">Apellidos</label>
			    <input type="text" name="apellidos" class="form-control" id="apellidos" required>
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
			    <label for="nombrePadre">Nombre del padre</label>
			    <input type="text" name="nombrePadre" class="form-control" id="nombrePadre" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Rellene este campo
			    </div>
			</div>
			<div class="form-group col-md-6">
			    <label for="nombreMadre">Nombre de la madre</label>
			    <input type="text" name="nombreMadre" class="form-control" id="nombreMadre" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Rellene este campo
			    </div>
			</div>
		    </div>


		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="correo">Correo electr&oacute;nico</label>
			    <input type="email" name="correo" class="form-control" id="correo"  required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un correo electr&oacute;nico valido
			    </div>
			</div>

			<div class="form-group col-md-6">
			    <label for="inputAddress">Direcci&oacute;n</label>
			    <input type="text" class="form-control" name="direccion" id="inputAddress"  placeholder="Jr Perú 123" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese algo aqu&iacute;
			    </div>
			</div>
		    </div>


		    <div class="form-row">
			<div class="form-group col-md-4">
			    <label for="dni">DNI</label>
			    <input type="text" class="form-control" name="dni" id="dni" required  mixlength="8" maxlength="8" pattern="[0-9]{8}">
			    <div class="invalid-feedback">
				Ingrese solo 8 n&uacute;meros
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="edad">Edad</label>
			    <input type="number" class="form-control"  name="edad" id="edad" min="10" max="120" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un n&uacute;mero natural mayor a 10 y menor 120
			    </div>
			</div>

		    </div>
		    <div class="form-group">
			<label for="fechaCreacion">Fecha de creaci&oacute;n</label>
			<input type="date" class="form-control" name="fechaCreacion" id="fechaCreacion" value="<?= date("Y-m-d"); ?>" max="<?= date("Y-m-d"); ?>" required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese una fecha válida
			</div>
		    </div>

		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" value="M" type="radio" name="sexo" id="masculino"  required>
			<label class="form-check-label" for="masculino">
			    Masculino
			</label>
		    </div>
		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" value="F" type="radio" name="sexo" id="femenino" >
			<label class="form-check-label" for="femenino">
			    Femenino
			</label>
		    </div>

		    <div class="form-group">
			<label for="rutaFoto">Escoja un foto</label>
			<input type="file" name="rutaFoto" class="form-control-file" id="rutaFoto">
		    </div>

		    <div class="form-group">
			<label for="comentario">Comentario</label>
			<textarea type="text" class="form-control" name="comentario"  id="comentario" > </textarea>
		    </div>
                    <button type="submit" class="btn btn-primary"> Registrar </button>
		    <a href="<?= base_url().'/alumnos'; ?>" class="btn btn-danger"> Cancelar </a>
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
