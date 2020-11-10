<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/alumnoPorCurso/".$id,
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
{
    $mensaje = $data["Detalles"];
    echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/malumnos';</script>";
}

$data = $data["Detalles"];

function traerGrado($id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
	CURLOPT_URL => "http://colibri.informaticapp.com/grados/".$id,
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
    $data = $data["Detalles"][0];

    return $data["grado"];
}

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Visualizar Mátricula</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">

	    <div class="widget-content" >
		<form  method="post" class="needs-validation" novalidate>
		    <div class="form-group">
			<label for="id_alumno">Alumno</label>
			<select id="id_alumno" name="id_alumno" class="form-control" disabled>
			    <option value="<?= $data[0]["idAlumno"]?>"> <?= $data[0]["nombres"]." ".$data[0]["apellidos"]; ?></option>
			</select>
		    </div>

		    <label for="tabla"> Lista de cursos del alumno - Peri&oacute;do <label class="font-weight-bold"> <?= $data[0]["ciclo"];?> </label> </label>
		    <table class="table table-bordered table-striped" id="tabla">
			<thead>
			    <tr>
				<th>Curso</th>
				<th>Grado</th>					
				<th>Secci&oacute;n</th>					
			    </tr>
			</thead>
			<?php foreach ($data as $info):/* var_dump($info);die;*/?>
			    <tbody>
				<tr class="odd gradeX">
				    <td> <?= $info["curso"]; ?></td>
				    <td> <?= traerGrado($info["id_grado"]); ?> </td>
				    <td> <?= $info["seccion"]; ?></td>			
				</tr>
			    </tbody>
			<?php endforeach; ?>
		    </table>
                    <a href="<?= base_url().'/malumnos'; ?>" class="btn btn-primary"> Volver </a>
		</form>
	    </div>

        </div>
    </div>
</div>
