<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Alumnos extends Controller
{
    public function listar()
    {
        $this->vistaSimple("alumnos/listar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("alumnos/ver", $data);
    }

    public function editar($id)
    {
        $data = ["id" => $id];
        $this->vistas("alumnos/editar", $data);
    }

    public function eliminar($id)
    {
        $data = ["id" => $id];
        $this->vistas("alumnos/eliminar", $data);
    }

    public function registrar()
    {
        $this->vistaSimple("alumnos/registrar");
    }
}
