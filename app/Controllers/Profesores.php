<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Profesores extends Controller
{
    public function listar()
    {
        $this->vistaSimple("profesores/listar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("profesores/ver", $data);
    }

    public function editar($id)
    {
        $data = ["id" => $id];
        $this->vistas("profesores/editar", $data);
    }

    public function eliminar($id)
    {
        $data = ["id" => $id];
        $this->vistas("profesores/eliminar", $data);
    }

    public function registrar()
    {
        $this->vistaSimple("profesores/registrar");
    }
}
