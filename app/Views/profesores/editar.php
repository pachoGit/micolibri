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
	$ruta = "/public/profesores/".$_FILES["rutaFoto"]["name"];
	$ruta2 = $_SESSION["ruta"]."profesores/".$_FILES["rutaFoto"]["name"];
	//$ruta2 = "/var/www/html/micolibri/public/profesores/".$_FILES["rutaFoto"]["name"];
	move_uploaded_file($_FILES["rutaFoto"]["tmp_name"], $ruta2);

	$curl = curl_init();

	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/profesores/".$_POST["idProfesor"],
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
				"&estudios=".$_POST["estudios"].
				"&id_cliente=".$_SESSION["cliente"].
				"&comentario=".$_POST["comentario"],
            CURLOPT_HTTPHEADER => array(
		$_SESSION["auth"]
            ),
        ));

	$response = curl_exec($curl);
	curl_close($curl);
    }
    else
    {
	$curl = curl_init();

	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/profesores/".$_POST["idProfesor"],
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
				"&estudios=".$_POST["estudios"].
				"&id_cliente=".$_SESSION["cliente"].
				"&comentario=".$_POST["comentario"],
            CURLOPT_HTTPHEADER => array(
		$_SESSION["auth"]
            ),
        ));

	$response = curl_exec($curl);
	curl_close($curl);

    }

    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];

    echo "<script> alert('".$mensaje."');window.location.href='".base_url().'/profesores/listar'."' </script>";
    
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/profesores/".$id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
	$_SESSION["auth"],
	"Cliente:".$_SESSION["cliente"]
    ),
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);
$mensaje = $data["Detalles"];

if ($data["Estado"] != 200)
    echo "<script> alert('".$mensaje."');window.location.href='".base_url().'/profesores/listar'."' </script>";

$data = $data["Detalles"][0];

?>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del profesor</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="nombres">Nombres</label>
			    <input type="hidden" name="idProfesor" value="<?= $id; ?>">
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
			    <input type="text" name="apellidos" value="<?= $data["apellidos"]; ?>" class="form-control" id="apellidos" readonly>
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
			    <input type="email" name="correo" value="<?= $data["correo"]; ?>" class="form-control" id="correo"  required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un correo electr&oacute;nico valido
			    </div>
			</div>

			<div class="form-group col-md-6">
			    <label for="inputAddress">Direcci&oacute;n</label>
			    <input type="text" class="form-control" value="<?= $data["direccion"]; ?>" name="direccion" id="inputAddress"  placeholder="Jr Perú 123" required>
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
			    <input type="text" class="form-control" value="<?= $data["dni"]; ?>" name="dni" id="dni" readonly  mixlength="8" maxlength="8" pattern="[0-9]{8}">
			    <div class="invalid-feedback">
				Ingrese solo 8 n&uacute;meros
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="edad">Edad</label>
			    <input type="number" class="form-control" value="<?= $data["edad"]; ?>"  name="edad" id="edad" min="10" max="120" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese un n&uacute;mero natural mayor a 10 y menor 120
			    </div>
			</div>

			<div class="form-group col-md-4">
			    <label for="estudios">Estudios</label>
			    <input type="text" class="form-control" value="<?= $data["estudios"]; ?>" name="estudios" id="estudios">
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese algo aqu&iacute;
			    </div>
			</div>

		    </div>
		    <div class="form-group">
			<label for="fechaCreacion">Fecha de creaci&oacute;n</label>
			<input type="date" class="form-control" name="fechaCreacion" id="fechaCreacion" value="<?= $data["fechaCreacion"]; ?>" max="<?= date("Y-m-d"); ?>" readonly>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese una fecha válida
			</div>
		    </div>

		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" value="M" <?php if ($data["sexo"] == "M") {echo "checked";} ?> type="radio" name="sexo" id="masculino"  required>
			<label class="form-check-label" for="masculino">
			    Masculino
			</label>
		    </div>
		    <div class="form-check form-check-inline form-group">
			<input class="form-check-input" value="F" <?php if ($data["sexo"] == "F") {echo "checked";} ?> type="radio" name="sexo" id="femenino" >
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
			<textarea type="text" class="form-control" name="comentario" id="comentario" > <?= $data["comentario"]; ?> </textarea>
		    </div>
                    <button type="submit" class="btn btn-primary"> Aceptar </button>
		    <a href="<?= base_url().'/profesores/listar'; ?>" class="btn btn-danger"> Cancelar </a>
		</form>
	    </div>
        </div>
    </div>
</div>
