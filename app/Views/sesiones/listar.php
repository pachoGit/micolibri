<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/sesiones",
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
$mensaje = $data["Detalles"];

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sesiones</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
			<tr>
			    <th>Usuario</th>
			    <th>Sesión</th>
			</tr>
                    </thead>
                    <tfoot>
			<tr>
			    <th>Usuario</th>
			    <th>Sesión</th>
			</tr>
                    </tfoot>
                    <tbody>
			<?php foreach ($data["Detalles"] as $sesion): ?>
			<tr>
			    <td><?= $sesion["nombres"]; ?></td>
			    <td><?= $sesion["sesion"]; ?></td>
			</tr>
			<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
