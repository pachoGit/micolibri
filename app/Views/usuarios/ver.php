<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
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
    echo "<script> alert('Hubo un error al mostrar el usuario');window.location.href='".base_url().'/usuarios'."' </script>";

$data = $data["Detalles"][0];


?>


<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del usuario</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form class="needs-validation" novalidate>
		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="nombres">Nombres</label>
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
			    <input type="email" name="correo" class="form-control" id="correo" value="<?= $data["correo"]; ?>" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un correo electr&oacute;nico valido
			    </div>
			</div>
			<div class="form-group col-md-6">
			    <label for="contra">Contrase&ntilde;a </label>
			    <input type="password" class="form-control" name="contra" id="contra" value="<?= $data["contra"]; ?>" minlength="3" readonly>
			    <div class="invalid-feedback">
				Rellene este campo
			    </div>
			</div>
		    </div>

		    <div class="form-group">
			<label for="inputAddress">Direcci&oacute;n</label>
			<input type="text" class="form-control" name="direccion" id="inputAddress" value="<?= $data["direccion"]; ?>" placeholder="1234 Main St" readonly>
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
			    <input type="number" class="form-control" value="<?= $data["edad"]; ?>" name="edad" id="edad" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un n&uacute;mero natural
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="id_perfil">Seleccione un perfil</label>
			    <select id="id_perfil" name="id_perfil" class="form-control" readonly>
				<option> <?= $data["perfil"]; ?></option>
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
			<input class="form-check-input" type="radio" name="sexo" id="masculino" <?php if ($data["sexo"] == "M") {echo "checked";} ?> value="M" disabled>
			<label class="form-check-label" for="masculino">
			    Masculino
			</label>
		    </div>
		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" type="radio" name="sexo" id="femenino" <?php if ($data["sexo"] == "F") {echo "checked";} ?> value="F" disabled>
			<label class="form-check-label" for="femenino">
			    Femenino
			</label>
		    </div>

		    <div class="form-group">
			<!--
			     <label for="rutaFoto">Escoja un foto</label>
			     <input type="file" name="rutaFoto" value="<?= $data["rutaFoto"]; ?>" class="form-control-file" id="rutaFoto" readonly>
			-->
			<img src="<?= base_url().$data["rutaFoto"]; ?>" class="rounded mx-auto d-block" witdh="200" height="200">
		    </div>

		    <div class="form-group">
			<label for="comentario">Comentario</label>
			<textarea type="text" class="form-control" name="comentario" value="<?= $data["comentario"]; ?>" id="comentario" readonly> <?= $data["comentario"]; ?> </textarea>
		    </div>
                    <a href="<?= base_url().'/usuarios'; ?>" class="btn btn-primary"> Volver </a>
		</form>
		
	    </div>

        </div>
    </div>
</div>



