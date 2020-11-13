<?php

session_start();

// Traer hijos de un modulo padre
function traerHijos($idpadre)
{
    $modulos = $_SESSION["permisos"];
    $hijos = []; // Almacena los modulos hijos
    foreach ($modulos as $modulo)
    {
	if ($modulo["id_moduloPadre"] == $idpadre)
	    array_push($hijos, $modulo);
    }
    return $hijos;
}

// Filtramos los modulos padres de hijos

$modulos = $_SESSION["permisos"];
$padres = []; // Modulos Padres
$hijos = [];  // Modulos Hijos

foreach ($modulos as $modulo)
{
    if (is_null($modulo["id_moduloPadre"])) // Es un modulo padre
    {
	$h = traerHijos($modulo["idModulo"]);
	array_push($padres, $modulo);
	array_push($hijos, $h);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Mi colibri - Colibri </title>

	<!-- Custom fonts for this template-->
	<link href="<?= base_url().'/public/vendor/fontawesome-free/css/all.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= base_url().'/public/css/sb-admin-2.min.css'; ?>" rel="stylesheet">

    </head>

    <body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

	    <!-- Sidebar -->
	    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		<!-- Sidebar - Brand -->
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		    <div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-laugh-wink"></i>
		    </div>
		    <div class="sidebar-brand-text mx-3">Mi institución</div>
		</a>


		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<div class="sidebar-heading">
		    Módulos
		</div>

		<?php
		$iconos = ["fas fa-fw fa-cog", "fas fa-fw fa-wrench", "fas fa-money-bill-alt",
			   "fas fa-fw fa-table"];
		$contador = 0;
		foreach ($padres as $padre)
		{
		?>

		<!-- Nav Item - Pages Collapse Menu -->
		<li class="nav-item">
		    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?= $contador; ?>" aria-expanded="true" aria-controls="collapse<?= $contador; ?>">
			<i class="<?= $iconos[$contador]; ?>"></i>
			<span><?= $padre["modulo"]; ?></span>
		    </a>
		    <div id="collapse<?= $contador; ?>" class="collapse" aria-labelledby="heading<?= $contador;?>" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
			    <h6 class="collapse-header">Submódulos:</h6>
			    <?php $este_hijo = $hijos[$contador]; foreach ($este_hijo as $hijo) { ?>
				<a class="collapse-item" href="<?= base_url().'/'.$hijo["url"]; ?>"><?= $hijo["modulo"];?></a>
			    <?php }  ?>
			</div>
		    </div>
		</li>
		<?php $contador += 1; } ?>

		<li class="nav-item">
		    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportes" aria-expanded="true" aria-controls="collapseTwo">
			<i class="fas fa-fw fa-cog"></i>
			<span>Reportes</span>
		    </a>
		    <div id="reportes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
			<div class="bg-white py-2 collapse-inner rounded">
			    <h6 class="collapse-header">Submódulos:</h6>
			    <a class="collapse-item" href="<?= base_url().'/matriculas'; ?>">Matrículas</a>
			    <a class="collapse-item" href="<?= base_url().'/ralumnos'; ?>">Alumnos</a>
			    <a class="collapse-item" href="<?= base_url().'/rprofesores'; ?>">Profesores</a>
			    <a class="collapse-item" href="<?= base_url().'/notas'; ?>">Notas</a>
			</div>
		    </div>
		</li>






		<!-- Divider -->
		<hr class="sidebar-divider d-none d-md-block">

		<!-- Sidebar Toggler (Sidebar) -->
		<div class="text-center d-none d-md-inline">
		    <button class="rounded-circle border-0" id="sidebarToggle"></button>
		</div>

	    </ul>
	    <!-- End of Sidebar -->

	    <!-- Content Wrapper -->
	    <div id="content-wrapper" class="d-flex flex-column">

		<!-- Main Content -->
		<div id="content">

		    <!-- Topbar -->
		    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

			<!-- Sidebar Toggle (Topbar) -->
			<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
			    <i class="fa fa-bars"></i>
			</button>

			<!-- Topbar Search -->
			<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
			    <div class="input-group">
				<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
				<div class="input-group-append">
				    <button class="btn btn-primary" type="button">
					<i class="fas fa-search fa-sm"></i>
				    </button>
				</div>
			    </div>
			</form>

			<!-- Topbar Navbar -->
			<ul class="navbar-nav ml-auto">

			    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
			    <li class="nav-item dropdown no-arrow d-sm-none">
				<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="fas fa-search fa-fw"></i>
				</a>
				<!-- Dropdown - Messages -->
				<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
				    <form class="form-inline mr-auto w-100 navbar-search">
					<div class="input-group">
					    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
					    <div class="input-group-append">
						<button class="btn btn-primary" type="button">
						    <i class="fas fa-search fa-sm"></i>
						</button>
					    </div>
					</div>
				    </form>
				</div>
			    </li>

			    <div class="topbar-divider d-none d-sm-block"></div>

			    <!-- Nav Item - User Information -->
			    <li class="nav-item dropdown no-arrow">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION["nombres"]; ?></span>
				    <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
				</a>
				<!-- Dropdown - User Information -->
				<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				    <div class="dropdown-divider"></div>
				    <a class="dropdown-item" href="<?= base_url().'/home/salir'; ?>" data-toggle="modal" data-target="#logoutModal">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Salir
				    </a>
				</div>
			    </li>

			</ul>

		    </nav>
		    <!-- End of Topbar -->
