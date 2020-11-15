<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

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
        "Cliente:".$_SESSION["cliente"],
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
            <h6 class="m-0 font-weight-bold text-primary">Visualizar pago</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >

		<form  method="post" class="needs-validation" novalidate>
	            <input type="hidden" name="idPago" value="<?= $data["idPago"]; ?>"> </input>
		    <div class="form-group">
			<label for="id_alumno">Información del alumno</label>
			<select id="id_alumno" name="id_alumno" class="form-control" disabled>
			    <option value="<?= $data["id_alumno"]; ?>"> <?= $data["nombres"]." ".$data["apellidos"]; ?></option>
			</select>
		    </div>

		    <div class="form-row">
			<div class="form-group col-md-6">
			    <label for="id_motivo">Motivo del pago</label>
			    <select id="id_motivo" name="id_motivo" class="form-control" disabled>
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
			<label for="monto">Monto</label>
			<input type="number" step="0.01" class="form-control" value="<?= $data["monto"];?>" name="monto" id="monto"  disabled>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese un monto;
			</div>
		    </div>

		    <a href="<?php echo base_url().'/pagos/listar_alumnos'?>" class="btn btn-primary mt-4">Volver</a>
		</form>

	    </div>

        </div>
    </div>
</div>
