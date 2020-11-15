<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
	CURLOPT_URL => "http://colibri.informaticapp.com/cursos/".$_POST["idCurso"],
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "PUT",
	CURLOPT_POSTFIELDS => 
            "curso=".$_POST["curso"].
			    "&id_tipo=".$_POST["id_tipo"].
			    "&id_categoria=".$_POST["id_categoria"].
			    "&id_cliente=".$_SESSION["cliente"].
			    "&id_naturaleza=".$_POST["id_naturaleza"],
	CURLOPT_HTTPHEADER => array(
	    $_SESSION["auth"]
	),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response, true);

    $mensaje = $data["Detalles"];
    echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/cursos/listar';</script>";
    return;

}
else
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/cursos/".$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cliente:".$_SESSION["cliente"],
            $_SESSION["auth"]
        ),
      ));
    $response = curl_exec($curl);
    curl_close($curl);
    
    $data = json_decode($response, true);
   
    $data = $data["Detalles"];
    $data = $data[0];
    // var_dump($data);die;
}

//esto trae tipo de curso
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://colibri.informaticapp.com/tipoCurso",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
      "cliente:".$_SESSION["cliente"],
      $_SESSION["auth"]
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$tipos = json_decode($response, true);
$tipos= $tipos["Detalles"];

//esto trae categoria de curso
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://colibri.informaticapp.com/categoriaCurso",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
      "cliente:".$_SESSION["cliente"],
      $_SESSION["auth"]
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$categorias = json_decode($response, true);
$categorias= $categorias["Detalles"];

//esto trae naturaleza de curso
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://colibri.informaticapp.com/naturalezaCurso",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
      "cliente:".$_SESSION["cliente"],
      $_SESSION["auth"]
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$naturalezas = json_decode($response, true);
$naturalezas= $naturalezas["Detalles"];


?>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar curso</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form  method="post" class="needs-validation" novalidate>
		    <div class="form-group">
			<input type="hidden" name="idCurso" value="<?= $data["idCurso"] ?>">
			<label for="curso">Nombre del curso</label>
			<input type="text" class="form-control" value="<?= $data["curso"]; ?>" name="curso" id="curso" required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese algo aqu&iacute;
			</div>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-4">
			    <label for="id_tipo">Seleccione el tipo del curso</label>
			    <select id="id_tipo" name="id_tipo" class="form-control" required>
				<?php foreach ($tipos as $tipo): ?>
				    <option value="<?= $tipo["idTipoCurso"]?>" <?php if ($tipo["tipo"] == $data["tipo"]) { echo "selected";} ?> > <?= $tipo["tipo"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
			<div class="form-group col-md-4">
			    <label for="id_categoria">Seleccione la categoria del curso</label>
			    <select id="id_categoria" name="id_categoria" class="form-control" required>
				<?php foreach ($categorias as $categoria): ?>
				    <option value="<?= $categoria["idCategoriaCurso"]?>" <?php if ($categoria["categoria"] == $data["categoria"]) { echo "selected";} ?> > <?= $categoria["categoria"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>
			<div class="form-group col-md-4">
			    <label for="id_naturaleza">Seleccione la naturaleza del curso</label>
			    <select id="id_naturaleza" name="id_naturaleza" class="form-control" required>
				<?php foreach ($naturalezas as $naturaleza): ?>
				    <option value="<?= $naturaleza["idNaturaleza"]?>"  <?php if ($naturaleza["naturaleza"] == $data["naturaleza"]) { echo "selected";} ?> > <?= $naturaleza["naturaleza"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>

		    </div>
		    
		    <button type="submit" class="btn btn-primary mt-3">Registrar</button>
		    <a href="<?= base_url().'/cursos/listar'; ?>" class="btn btn-danger mt-3"> Cancelar </a>

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
