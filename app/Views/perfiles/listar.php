<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/perfiles",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
      $_SESSION["auth"], "Cliente:".$_SESSION["cliente"]
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if ($data["Estado"] != 200)
    echo "<script> window.alert('Hubo un error al traer los datos'); </script>"

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Perfiles</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/perfiles/registrar'; ?>"> Registrar </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
			<tr>
			    <th>Perfil</th>
			    <th>Fecha de creación</th>
			    <th colspan="3" class="text-center">Acciones</th>
			</tr>
                    </thead>
                    <tfoot>
			<tr>
			    <th>Perfil</th>
			    <th>Fecha de creación</th>
			    <th colspan="3" class="text-center">Acciones</th>			    
			</tr>
                    </tfoot>
                    <tbody>
			<?php foreach ($data["Detalles"] as $perfil): ?>
			<tr>
			    <td><?= $perfil["perfil"]; ?></td>
			    <td><?= $perfil["fechaCreacion"]; ?></td>
			    <td class="text-center">
				<a href="<?= base_url().'/perfiles/ver/'.$perfil["idPerfil"]; ?>" class="btn btn-info btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-info-circle"></i>
				    </span>
				    <span class="text">Ver</span>
				</a>
			    </td>
			    <td class="text-center">
				<a href="<?= base_url().'/perfiles/editar/'.$perfil["idPerfil"]; ?>" class="btn btn-warning btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-exclamation-triangle"></i>
				    </span>
				    <span class="text">Editar</span>
				</a>
			    </td>
			    <td class="text-center">
				<a onclick="return alerta()" href="<?= base_url().'/perfiles/eliminar/'.$perfil["idPerfil"]; ?>" class="btn btn-danger btn-icon-split">
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
      var r = confirm("Desea eliminar este perfil?");
      if (r)
	  return true;
      else
	  return false;
  }
</script>
