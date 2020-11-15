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
        CURLOPT_URL => "http://colibri.informaticapp.com/sedes",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => 
        "sede=".$_POST["sede"].
        "&direccion=".$_POST["direccion"].
        "&id_cliente=".$_SESSION["cliente"], 
        CURLOPT_HTTPHEADER => array(
            $_SESSION["auth"]
                                    ),
                                   ));

    $response = curl_exec($curl);

    curl_close($curl);
    $data = json_decode($response, true);
    $mensaje = $data["Detalles"];
    echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/sedes/listar';</script>";
}

?>




<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar sede</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >

		<form  method="post" class="needs-validation" novalidate>
		    
		    <!-- <div class="form-group col-md-6"> -->
		    <label for="nombres">Nombre de la Sede</label>
		    <input type="text" name="sede" class="form-control" id="sede" required>
		    <div class="valid-feedback">
			Esto est&aacute; bien
		    </div>
		    <div class="invalid-feedback">
			Ingrese el nombre de la sede
		    </div>
		    <!-- </div> -->
		    <!-- <div class="form-group col-md-6"> -->
		    <label for="nombres">Direccion de la Sede</label>
		    <input type="text" name="direccion" class="form-control" id="direccion" required>
		    <div class="valid-feedback">
			Esto est&aacute; bien
		    </div>
		    <div class="invalid-feedback">
			Ingrese la direccion de la sede
		    </div>
		    <!-- </div> -->
		    
		    <button type="submit" class="btn btn-primary mt-4">Registrar</button>
		    <a href="<?php echo base_url().'/sedes/listar'?>" class="btn btn-danger mt-4">Cancelar</a>
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
