<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/usuarios",
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

/*
if ($data["Estado"] != 200)
    echo "<script> window.alert('".$mensaje."'); </script>";
*/

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/usuarios/registrar'; ?>"> Registrar </a>
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
			    <th>DNI</th>
			    <th>Edad</th>
			    <th>Sexo</th>
			    <th>Foto</th>
			    <th></th>
			    <th></th>
			    <th></th>

			</tr>
                    </thead>
                    <tfoot>
			<tr>
			    <th>Nombres</th>
			    <th>Apellidos</th>
			    <th>DNI</th>
			    <th>Edad</th>
			    <th>Sexo</th>
			    <th>Foto</th>
			    <th></th>
			    <th></th>
			    <th></th>
			</tr>
                    </tfoot>
                    <tbody>
			<?php foreach ($data["Detalles"] as $usuario): ?>
			<tr>
			    <td><?= $usuario["nombres"]; ?></td>
			    <td><?= $usuario["apellidos"]; ?></td>
			    <td><?= $usuario["dni"]; ?></td>
			    <td><?= $usuario["edad"]; ?></td>
			    <td><?= $usuario["sexo"]; ?></td>
			    <td class="text-center"><img witdh="80" height="80" src="<?= base_url().$usuario['rutaFoto']; ?>" ></td>
			    <td class="text-center">
				<a href="<?= base_url().'/usuarios/ver/'.$usuario["idUsuario"]; ?>" class="btn btn-info btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-info-circle"></i>
				    </span>
				    <span class="text">Ver</span>
				</a>
			    </td>
			    <td class="text-center">
				<a href="<?= base_url().'/usuarios/editar/'.$usuario["idUsuario"]; ?>" class="btn btn-warning btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-exclamation-triangle"></i>
				    </span>
				    <span class="text">Editar</span>
				</a>
			    </td>
			    <?php if ($data["Total"] != 1) {?>
			    <td class="text-center">
				<a onclick="return alerta()" href="<?= base_url().'/usuarios/eliminar/'.$usuario["idUsuario"]; ?>" class="btn btn-danger btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-trash"></i>
				    </span>
				    <span class="text">Eliminar</span>
				</a>
			    </td>
			    <?php } ?>
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
      var r = confirm("Desea eliminar a este usuario?");
      if (r)
	  return true;
      else
	  return false;
  }
</script>
