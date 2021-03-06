<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $existeCursos = false;
    foreach ($_POST as $clave => $valor)
    {
	if ($clave == "cursos")
	{
	    $existeCursos = true;
	    break;
	}
    }
    if ($existeCursos == false)
    {
	echo "<script>alert('ERROR: Agregue al menos un curso');window.location.href = '".base_url()."/alumnoPorCurso/registrar';</script>";
    }

    $data = "";
    $cont = 0;
    foreach ($_POST["cursos"] as $curso)
    {
	$curl = curl_init();
	curl_setopt_array($curl, array(
            CURLOPT_URL => "http://colibri.informaticapp.com/alumnoPorCurso",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>
		"id_alumno=".$_POST["id_alumno"].
				"&id_curso=".$curso.
				"&id_seccion=".$_POST["secciones"][$cont++].
				"&id_ciclo=".$_POST["id_ciclo"].
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
	{
	    $mensaje = $data["Detalles"];
	    echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/alumnoPorCurso/listar';</script>";
	}
    }
    $mensaje = $data["Detalles"];

    // Redireccion despues de insertar
    echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/alumnoPorCurso/listar';</script>";
}

// Traemos los alumnos
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/alumnos",
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

if ($data["Estado"] != 200)
{
    $mensaje = $data["Detalles"];
    echo "<script> window.alert('".$mensaje."'); </script>";
}
$alumnos = $data["Detalles"];

// Traemos los grados
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/grados",
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

$grados = $data["Detalles"];

// Traemos los ciclos
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/ciclos",
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

$ciclos = $data["Detalles"];

// Traemos los cursos
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/cursos",
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

$cursos = $data["Detalles"];


?>

<script src="<?= base_url().'/public/ayudas/ajax.js'; ?>" type="text/javascript"> </script>
<script src="<?= base_url().'/public/ayudas/malumnos.js'; ?>" type="text/javascript"> </script>
<script src="<?= base_url().'/public/ayudas/tabla-matricula.js'; ?>" type="text/javascript"> </script>

<div class="container-fluid">
    <!-- Page Heading -->
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar matrícula</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		<form  method="post" class="needs-validation" novalidate>
		    <div class="form-group">
			<label for="id_alumno">Seleccione a un alumno</label>
			<select id="id_alumno" name="id_alumno" class="form-control" required>
			    <?php foreach ($alumnos as $alumno):?>
				<option value="<?= $alumno["idAlumno"]?>"> <?= $alumno["nombres"]." ".$alumno["apellidos"]; ?></option>
			    <?php endforeach; ?> 
			</select>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-4">
			    <label for="id_grado">Seleccione el grado</label>
			    <select onchange="secciones()" cliente="<?= $_SESSION["cliente"] ?>"  id="id_grado" name="id_grado" class="form-control" required>
				<option value=""></option>					
				<?php foreach ($grados as $grado): ?>
				    <option value="<?= $grado["idGrado"]?>"> <?= $grado["grado"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
			<p id="hola"> </p>
			<div class="form-group col-md-4">
			    <label for="id_seccion">Seleccione la secci&oacute;n</label>
			    <select id="id_seccion" name="id_seccion" class="form-control" required>
			    </select>
			</div>

			<div class="form-group col-md-4">
			    <label for="id_ciclo">Seleccione el peri&oacute;do</label>
			    <select id="id_ciclo" name="id_ciclo" class="form-control" required>
				<?php foreach ($ciclos as $ciclo): ?>
				    <option value="<?= $ciclo["idCiclo"]?>"> <?= $ciclo["ciclo"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-9">
			    <label for="monto">Seleccione los cursos que llevar&aacute; el alumno</label>
			    <select id="id_curso" name="id_curso" class="form-control" required>
				<?php foreach ($cursos as $curso): ?>
				    <option value="<?= $curso["idCurso"]?>"> <?= $curso["curso"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
			<div class="form-group col-md-3">
			    <label for="boton"> A&ntilde;adir </label>
			    <input class="form-control btn btn-outline-primary" onclick="agregarEnTabla()" id="boton" type="button" value="Agregar curso">
			</div>
		    </div>

		    <table class="table table-bordered table-striped" id="tabla">
			<thead>
			    <tr>
				<th>Cursos</th>
				<th>Grado</th>
				<th>Sección</th>
				<th class="text-center">Acci&oacute;n</th>
			    </tr>
			</thead>
			<tbody>
			    
			</tbody>
		    </table>

		    <div class="form-group" id="cursos">

		    </div>
		    
		    <div class="form-group" id="secciones">

		    </div>
		    <button onclick="formarCheckboxs()"  type="submit" class="btn btn-primary">Registrar</button>
                    <a href="<?= base_url().'/alumnoPorCurso/listar'; ?>" class="btn btn-danger"> Cancelar </a>
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

