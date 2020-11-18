<script src="<?= base_url().'/public/ayudas/ajax.js'; ?>"> </script>

<script type="text/javascript">

 function hacerReporte(respuesta)
 {
     let profesores = JSON.parse(respuesta);
     let i;
     let tbody = "";
     let cuerpo = document.getElementById("tabla").getElementsByTagName("tbody")[0];
     let nuevaFila;
     let total = document.getElementById("total").innerHTML = profesores.length;

     if (profesores.length <= 0)
     {
	 alert("No se encontraron registros");
	 document.getElementById("boton-pdf").style.visibility = "hidden"; // Ocultar el boton del pdf
	 for (i = cuerpo.rows.length-1; i >= 0; i--)
	     cuerpo.deleteRow(i);
	 return;
     }
     // Mostrar el boton del pdf
     document.getElementById("boton-pdf").style.visibility = "visible";

     if (cuerpo.rows.length > 0)
     {
	 // Borramos la tabla
	 // Lo hago en descendente, por que asi funciona :D
	 // Hablando en serio jajaja, si lo pongo en ascendente queda como
	 // huecos cada vez que se elimina una fila... una teoria es que al borrar
	 // el elemento 0.. el elemento 1 toma su lugar (es decir ahora es el cero),
	 // y ya te imaginaras lo que pasa :D
	 for (i = cuerpo.rows.length-1; i >= 0; i--)
	     cuerpo.deleteRow(i);
     }

     //let total = document.getElementById("total").innerHTML = profesores.length;

     for (i = 0; i < 4; i++)
     {
	 if (profesores[i] === undefined)
	     break;
	 nuevaFila = cuerpo.insertRow(cuerpo.rows.length);	 
	 tbody += "<tr>";
	 tbody += "<td>" + profesores[i].nombres  + "</td>";
	 tbody += "<td>" + profesores[i].apellidos + "</td>";
	 tbody += "<td>" + profesores[i].dni + "</td>";
	 tbody += "<td>" + profesores[i].edad + "</td>";
	 tbody += "</tr>";
	 nuevaFila.innerHTML = tbody;
	 tbody = "";
     }
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
     ruta = "http://colibri.informaticapp.com/funcsAjax/reporte_profesores";

     ajax_reportes(desde, hasta, cliente, ruta, hacerReporte);
 }

</script>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reportes de profesores</h6>
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


			<div class="form-group col-md-3 ml-5 pl-5">
			    <label for="hasta">Fecha de consulta</label>
			    <input type="date" class="form-control" value="<?= date("Y-m-d"); ?>" name="hasta" id="hasta"  max="<?= date("Y-m-d"); ?>" readonly>
			    <div class="valid-feedback">
				Esto est&aacute; bien
			    </div>
			    <div class="invalid-feedback">
				Elija una fecha válida
			    </div>
			</div>


		    </div>

		    <div class="form-group">
			<input type="button" style="visibility: hidden;" id="boton-pdf" class="btn btn-success" value="PDF">
		    </div>
		    
		    <table class="table table-bordered table-striped" id="tabla">
			<thead>
			    <tr>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>DNI</th>
				<th>Edad</th>
			    </tr>
			</thead>
			<tbody>
			    
			</tbody>
			<tfooter>
			    <tr>
				<th></th>
				<th></th>
				<th>Total</th>
				<th id="total">0</th>
			    </tr>
			</tfooter>
		    </table>
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
