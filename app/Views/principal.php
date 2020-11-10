<?php

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

?>

<div class="container-fluid">
    <!-- Page Heading -->
    <p> Bienvenido </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">

        </div>
    </div>
</div>
