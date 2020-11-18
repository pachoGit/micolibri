<script src="<?= base_url().'/public/ayudas/ajax.js'; ?>"> </script>

<script type="text/javascript">

 function hacerReporte(respuesta)
 {
     alert(respuesta);
 }

 function buscar()
 {
     let desde, hasta, cliente, ruta;

     desde = document.getElementById("desde").value;
     hasta = document.getElementById("hasta").value;

     if (desde === "" || hasta === "")
     {
	 alert("Seleccione un rango de fechas por favor");
	 return;
     }
     cliente = <?= $_SESSION["cliente"]; ?>;
     ruta = "http://colibri.informaticapp.com/funcsAjax/reporte_matricula";

     ajax_reportes(desde, hasta, cliente, ruta, hacerReporte);
 }

</script>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reportes de matrículas</h6>
        </div>
        <div class="card-body">

	    <div class="widget-content" >
		
		<form class="needs-validation" method="post" novalidate>
		    <div class="form-row">
			<div class="form-group col-md-3">
			    <label for="desde">Desde</label>
			    <input type="date" class="form-control" name="desde" id="desde" max="<?= date("Y-m-d"); ?>" required>
			    <div class="invalid-feedback">
				Elija una fecha válida
			    </div>
			</div>

			<div class="form-group col-md-3">
			    <label for="hasta">Hasta</label>
			    <input type="date" class="form-control" value="<?= date("Y-m-d"); ?>" name="hasta" id="hasta"  max="<?= date("Y-m-d"); ?>" required>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Elija una fecha válida
			    </div>
			</div>

			<div class="form-group col-md-1">
			    <label for="buscar">Buscar</label>
			    <input type="button" onclick="buscar()" class="form-control btn btn-primary" value="Buscar" name="search" id="search">
			</div>

		    </div>
		</form>
		
	    </div>

        </div>
    </div>
</div>

<script>
 // Example starter JavaScript for disabling form submissions if there are invalid fields
 (function() {
     'use strict';
     window.addEventListener('load', function() {
	 // Fetch all the forms we want to apply custom Bootstrap validation styles to
	 var forms = document.getElementsByClassName('needs-validation');
	 // Loop over them and prevent submission
	 var validation = Array.prototype.filter.call(forms, function(form) {
	     form.addEventListener('submit', function(event) {
		 if (form.checkValidity() === false) {
		     event.preventDefault();
		     event.stopPropagation();
		 }
		 form.classList.add('was-validated');
	     }, false);
	 });
     }, false);
 })();
</script>
