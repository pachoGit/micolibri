<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/pagos",
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

$data = json_decode($response, true);

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Pagos de alumnos</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/pagos/registrar_alumno'; ?>"> Registrar </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
			<tr>
			    <th>Nombres</th>
			    <th>Apellidos</th>
			    <th>Persona</th>
			    <th>DNI</th>
			    <th>Monto</th>
			    <th>Fecha de pago</th>
			    <th>Motivo</th>
			    <th></th>
			    <th></th>
			    <th></th>
			    <!-- <th colspan="3" class="text-center">Acciones</th> -->
			</tr>
                    </thead>
                    <tfoot>
			<tr>
			    <th>Nombres</th>
			    <th>Apellidos</th>
			    <th>Persona</th>
			    <th>DNI</th>
			    <th>Monto</th>
			    <th>Fecha de pago</th>
			    <th>Motivo</th>
			    <th></th>
			    <th></th>
			    <th></th>
			    <!-- <th colspan="3" class="text-center">Acciones</th> -->
			</tr>
                    </tfoot>
                    <tbody>
			<?php foreach ($data["alumnos"] as $pago): ?>
			<tr>
			    <td><?= $pago["nombres"]; ?></td>
			    <td><?= $pago["apellidos"]; ?></td>
			    <td><?php if (is_null($pago['id_alumno'])) { echo "Profesor"; }else { echo "Alumno";}  ?></td>
			    <td><?= $pago["dni"]; ?></td>
			    <td><?= $pago["monto"]; ?></td>
			    <td><?= $pago["fechaPago"]; ?></td>
			    <td><?= $pago["motivo"]; ?></td>
			    <td class="text-center">
				<a href="<?= base_url().'/pagos/ver_alumno/'.$pago["idPago"]; ?>" class="btn btn-info btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-info-circle"></i>
				    </span>
				    <span class="text">Ver</span>
				</a>
			    </td>
			    <td class="text-center">
				<a href="<?= base_url().'/pagos/editar_alumno/'.$pago["idPago"]; ?>" class="btn btn-warning btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-exclamation-triangle"></i>
				    </span>
				    <span class="text">Editar</span>
				</a>
			    </td>
			    <td class="text-center">
				<a onclick="return alerta()" href="<?= base_url().'/pagos/eliminar_alumno/'.$pago["idPago"]; ?>" class="btn btn-danger btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-trash"></i>
				    </span>
				    <span class="text">Eliminar</span>
				</a>
			    </td>
			</tr>
			<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  function alerta()
  {
      var r = confirm("Desea eliminar a este pago?");
      if (r)
	  return true;
      else
	  return false;
  }
</script>

