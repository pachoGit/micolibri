<?php

session_start();

if (!isset($_SESSION["nombres"]))
{
    echo "<script>alert('Usted no ha iniciado sesión');window.location.href = '".base_url()."';</script>";
    return;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://colibri.informaticapp.com/cursos/".$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "DELETE",
  CURLOPT_HTTPHEADER => array(
      "cliente:".$_SESSION["cliente"],
      $_SESSION["auth"]
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$data = json_decode($response, true);
$mensaje = $data["Detalles"];
echo "<script>alert('".$mensaje."');window.location.href = '".base_url()."/cursos/listar';</script>";
