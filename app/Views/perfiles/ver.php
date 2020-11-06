<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://colibri.informaticapp.com/perfiles/".$id,
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
    echo "<script> alert('Hubo un error al mostrar el perfil');window.location.href='".base_url().'/perfiles'."' </script>";

$permisos = $data["permisos"];
$data = $data["Detalles"][0];

?>


<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del perfil</h6>
        </div>
        <div class="card-body">
	    <div class="widget-content" >

		<form  class="needs-validation" novalidate>
		    <div class="form-group">
			<label for="perfil">Nombre del perfil</label>
			<input type="text" class="form-control" value="<?= $data["perfil"]; ?>" name="perfil" id="perfil" readonly>
			<div class="valid-feedback">
			    Esto est&aacute; bien
			</div>
			<div class="invalid-feedback">
			    Ingrese algo aqu&iacute;
			</div>
		    </div>

		    <label> Permisos del perfil de usuario </label>
		    <div class="container row">
			<?php foreach ($permisos as $permiso):
			 if (is_null($permiso["id_moduloPadre"])) {
			?>
			    <div class="col">
				<div class="form-check form-check-inline">
				    <input class="form-check-input ml-5" type="checkbox" name="permisosP[]" value="<?= $permiso["idModulo"];?>" id="permisosP" checked disabled>
				    <label class="form-check-label" for="permisosP">
					<?= $permiso["modulo"]; ?>
				    </label>
				</div>
			    </div>
			<?php } endforeach; ?>
		    </div>

		    <div class="container row mb-4">
			<?php
			foreach  ($permisos as $modulo) {
			    if (is_null($modulo["id_moduloPadre"])) {
				$padre = $modulo;
			?>
			    <div class="col">
				<?php 
				foreach ($permisos as $hijo)
				{
				    if ($hijo["id_moduloPadre"] == $padre["idModulo"])
				    {
				?>	
				    <div class="form-check">
					<input class="form-check-input" type="checkbox" name="modulos[]" value="<?= $hijo["idModulo"];?>" id="modulosH" checked disabled >
					<label class="form-check-label" for="modulosH">
					    <?= $hijo["modulo"]; ?>
					</label>
				    </div>
				<?php
				}
				}
				?>
			    </div>
			    <?php
			    }
			    }
			    ?>

		    </div>

		    <a href="<?= base_url().'/perfiles'; ?>" class="btn btn-primary mt-3"> Volver </a>
		</form>

	    </div>
        </div>
    </div>
</div>
