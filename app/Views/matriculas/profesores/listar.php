<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/curSecPorProfesor",
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

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Matrículas profesores</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/curSecPorProfesor/registrar'; ?>"> Registrar </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

		<table class="table table-bordered" id="dataTable">
		    <thead class="thead-dark">
			<tr>
			    <th>Nombres</th>
			    <th>Apellidos</th>
			    <th>Periodo</th>
			    <th>Fecha</th>
			    <th></th>
			    <th></th>
			</tr>
		    </thead>

		    <?php
		    if ($data["Estado"] == 200) {
			$repetidos = []; foreach($data["Detalles"] as $profesor) {
			    $existe = false;
			    foreach ($repetidos as $clave => $valor)
			    {
				if ($clave == $profesor["idProfesor"] and $valor == $profesor["ciclo"])
				{
				    $existe = true;
				    break;
				}

			    }
			    if ($existe == false)
			    {
				$repetidos[$profesor["idProfesor"]] = $profesor["ciclo"];
		    ?>
			<tbody>
			    <tr>
				<td><?php echo $profesor['nombres']; ?></td>
				<td><?php echo $profesor['apellidos']; ?></td>
				<td><?php echo $profesor['ciclo']; ?></td>
				<td><?php echo $profesor['fechaCreacion']; ?></td>
				<td class="text-center">
				    <a href="<?= base_url().'/curSecPorProfesor/ver/'.$profesor["idCurSecPorProfesor"]; ?>" class="btn btn-info btn-icon-split">
					<span class="icon text-white-50">
					    <i class="fas fa-info-circle"></i>
					</span>
					<span class="text">Ver</span>
				    </a>
				</td>
				<td class="text-center">
				    <a onclick="return alerta()" href="<?= base_url().'/curSecPorProfesor/eliminar/'.$profesor["idCurSecPorProfesor"]; ?>" class="btn btn-danger btn-icon-split">
					<span class="icon text-white-50">
					    <i class="fas fa-trash"></i>
					</span>
					<span class="text">Eliminar</span>
				    </a>
				</td>

			    </tr>
			</tbody>
		    <?php
		    }
		    }
		    }
		    ?>	    
		</table>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  function alerta()
  {
      var r = confirm("Desea eliminar a esta matrícula?");
      if (r)
	  return true;
      else
	  return false;
  }
</script>
