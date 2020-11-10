<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/alumnoPorCurso",
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
    echo "<script> window.alert('Hubo un error al traer los datos'); </script>";

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Matrículas alumnos</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/malumnos/registrar'; ?>"> Registrar </a>
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
			$repetidos = []; foreach($data["Detalles"] as $alumno) {
			    $existe = false;
			    foreach ($repetidos as $clave => $valor)
			    {
				if ($clave == $alumno["idAlumno"] and $valor == $alumno["ciclo"])
				{
				    $existe = true;
				    break;
				}

			    }
			    if ($existe == false)
			    {
				$repetidos[$alumno["idAlumno"]] = $alumno["ciclo"];
		    ?>
			<tbody>
			    <tr>
				<td><?php echo $alumno['nombres']; ?></td>
				<td><?php echo $alumno['apellidos']; ?></td>
				<td><?php echo $alumno['ciclo']; ?></td>
				<td><?php echo $alumno['fechaCreacion']; ?></td>
				<td><a href="malumnos/ver/<?= $alumno['idAlumnoPorCurso']?>" class="btn
					     btn-secondary">Ver</a></td>
				<td><a onclick="return alerta();" href="malumnos/eliminar/<?= $alumno['idAlumnoPorCurso']?>"
				       class="btn btn-danger">Eliminar</a></td>
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
