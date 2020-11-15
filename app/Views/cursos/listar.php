<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://colibri.informaticapp.com/cursos",
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


?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cursos</h1>
    <div>
	<a class="btn btn-primary mb-2" href="<?= base_url().'/cursos/registrar'; ?>"> Registrar </a>
	<button data-toggle="modal" data-target="#tipo" class="btn btn-secondary mb-1 ml-5">Tipos de cursos</button>
        <button data-toggle="modal" data-target="#categoria" class="btn btn-info mb-1 ml-5">Categorias de cursos</button>
        <button data-toggle="modal" data-target="#naturaleza" class="btn btn-dark mb-1 ml-5">Naturalezas de cursos</button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
			<tr>
			    <th>Curso</th>
			    <th>Tipo</th>
			    <th>Categoria</th>
			    <th>Naturaleza</th>
			    <th></th>
			    <th></th>
			    <!-- <th colspan="3" class="text-center">Acciones</th> -->
			</tr>
                    </thead>
                    <tfoot>
			<tr>
			    <th>Curso</th>
			    <th>Tipo</th>
			    <th>Categoria</th>
			    <th>Naturaleza</th>
			    <th></th>
			    <th></th>
			    <!-- <th colspan="3" class="text-center">Acciones</th> -->
			</tr>
                    </tfoot>
                    <tbody>
			<?php foreach ($data["Detalles"] as $curso): ?>
			<tr>
			    <td><?= $curso["curso"]; ?></td>
			    <td><?= $curso["tipo"]; ?></td>
			    <td><?= $curso["categoria"]; ?></td>
			    <td><?= $curso["naturaleza"]; ?></td>
			    <td class="text-center">
				<a href="<?= base_url().'/cursos/editar/'.$curso["idCurso"]; ?>" class="btn btn-warning btn-icon-split">
				    <span class="icon text-white-50">
					<i class="fas fa-exclamation-triangle"></i>
				    </span>
				    <span class="text">Editar</span>
				</a>
			    </td>
			    <td class="text-center">
				<a onclick="return alerta()" href="<?= base_url().'/cursos/eliminar/'.$curso["idCurso"]; ?>" class="btn btn-danger btn-icon-split">
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
      var r = confirm("Desea eliminar a este curso?");
      if (r)
	  return true;
      else
	  return false;
  }
</script>


<!-- Nuevo tipo de curso -->
<div class="modal fade" id="tipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Registrar nuevo tipo de curso</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		</button>
	    </div>
	    <div class="modal-body">
		<form class="form-signin" method="post" action="<?= base_url().'/tipoCurso/crear';?>">
		    <div class="form-group">
			<label for="tipo">Ingrese el nuevo tipo</label>
			<input class="form-control" name="tipo" id="tipo" required>
		    </div>
		    <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
		</form>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		<!--<button type="button" class="btn btn-primary">Save changes</button>-->
	    </div>
	</div>
    </div>
</div> 

<!-- Nueva categoria de curso -->
<div class="modal fade" id="categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Registrar nueva categoria de curso</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		</button>
	    </div>
	    <div class="modal-body">
		<form class="form-signin" method="post" action="<?= base_url().'/categoriaCurso/crear';?>">
		    <div class="form-group">
			<label for="categoria">Ingrese la nueva categoria</label>
			<input class="form-control" name="categoria" id="categoria" required>
		    </div>
		    <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
		</form>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	    </div>
	</div>
    </div>
</div> 


<!-- Nuevo naturaleza de curso -->
<div class="modal fade" id="naturaleza" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<div class="modal-content">
	    <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Registrar nueva naturaleza de curso</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		</button>
	    </div>
	    <div class="modal-body">
		<form class="form-signin" method="post" action="<?= base_url().'/naturalezaCurso/crear';?>">
		    <div class="form-group">
			<label for="naturaleza">Ingrese la nueva naturaleza</label>
			<input class="form-control" name="naturaleza" id="naturaleza" required>
		    </div>
		    <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar</button>
		</form>
	    </div>
	    <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	    </div>
	</div>
    </div>
</div> 
