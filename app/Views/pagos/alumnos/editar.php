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
        CURLOPT_URL => "http://colibri.informaticapp.com/pagos/".$_POST["idPago"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS =>
        "monto=".$_POST["monto"].
        "&fechaPago=".$_POST["fechaPago"].
        "&id_motivo=".$_POST["id_motivo"],
        CURLOPT_HTTPHEADER => array(
            $_SESSION["auth"]
                                    ),
                                   ));

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    
    $mensaje = $data["Detalles"];
    // Redireccion despues de insertar
    echo "<script>alert('".$mensaje."');window.location.href = '". base_url().'/pagos/listar_alumnos'."';</script>";
    return;
}
else
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://colibri.informaticapp.com/pagos/".$id,
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

    if ($data["Estado"] != 200)
    {
        $mensaje = $data["Detalles"];
        echo "<script>alert('".$mensaje."');window.location.href = '". base_url().'/pagos/listar_alumnos'."';</script>";
    }
    $data = $data["Detalles"][0];
    //var_dump($data);
    //die;
    
}
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
        "cliente:".$_SESSION["cliente"],
        $_SESSION["auth"]
                                ),
                               ));

$response = curl_exec($curl);
curl_close($curl);

$alumnos = json_decode($response, true);
$alumnos = $alumnos['Detalles'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/motivoPago",
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

$motivos = json_decode($response, true);
$motivos = $motivos['Detalles'];


?>


<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar pago</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >

		<form  method="post" class="needs-validation" novalidate>
	            <input type="hidden" name="idPago" value="<?= $data["idPago"]; ?>"> </input>
		    <div class="form-group">
			<label for="id_alumno">Seleccione a un alumno</label>
			<select id="id_alumno" name="id_alumno" class="form-control" disabled>
			    <option value="<?= $data["id_alumno"]; ?>"> <?= $data["nombres"]." ".$data["apellidos"]; ?></option>
			</select>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="id_motivo">Seleccione el motivo del pago</label>
			    <select id="id_motivo" name="id_motivo" class="form-control" required>
				<?php foreach ($motivos as $motivo): ?>
				    <option <?php if ($motivo["idMotivo"] == $data["id_motivo"]) { echo "selected"; }?> value="<?= $motivo["idMotivo"]?>"> <?= $motivo["motivo"]; ?></option>
				<?php endforeach; ?> 
			    </select>
			</div>

			<div class="form-group col-md-6">
			    <label for="fechaPago">Fecha del pago</label>
			    <input type="date" class="form-control" value="<?= $data["fechaPago"];?>" name="fechaPago" id="fechaPago" max="<?= date("Y-m-d") ?>" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Ingrese una fecha v&aacute;lida
			    </div>
			</div>
		    </div>

		    <div class="form-group">
			<label for="monto">Ingrese el monto</label>
			<input type="number" step="0.01" class="form-control" value="<?= $data["monto"];?>" name="monto" id="monto"  required>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese un monto;
			</div>
		    </div>

		    <button type="submit" class="btn btn-primary mt-4">Aceptar</button>
		    <a href="<?php echo base_url().'/pagos/listar_alumnos'?>" class="btn btn-danger mt-4">Cancelar</a>
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
