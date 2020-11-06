		    <div class="container row">
			<?php foreach ($modulos as $modulo):
			if (is_null($modulo["id_moduloPadre"])) {
			    foreach ($permisos as $permiso) {
				if ($permiso["id_modulo"] == $modulo["idModulo"]) {
			?>
			    <div class="col">
				<div class="form-check form-check-inline">
				    <input class="form-check-input ml-5" type="checkbox" name="modulos[]" value="<?= $modulo["idModulo"];?>" id="modulosP" checked>
				    <label class="form-check-label" for="modulosP">
					<?= $modulo["modulo"]; ?>
				    </label>
				</div>
			    </div>
			<?php } else { ?>
			    <div class="col">
				<div class="form-check form-check-inline">
				    <input class="form-check-input ml-5" type="checkbox" name="modulos[]" value="<?= $modulo["idModulo"];?>" id="modulosP">
				    <label class="form-check-label" for="modulosP">
					<?= $modulo["modulo"]; ?>
				    </label>
				</div>
			    </div>
			<?php } }} endforeach; ?>
		    </div>

<?php

foreach ($modulos as $modulo)
{
    if (is_null($modulo["id_moduloPadre"]))
    {
        foreach ($permisos as $permiso)
        {
            if ($permiso["id_modulo"] == $modulo["idModulo"])
            {
                checked;
                break;
            }
            else
            {
                no checked
                        break;
            }
        }
    }
}


?>
