<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Perfiles extends Controller
{
    public function listar()
    {
        $this->vistaSimple("perfiles/listar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("perfiles/ver", $data);
    }

    public function editar($id)
    {
        $data = ["id" => $id];
        $this->vistas("perfiles/editar", $data);
    }

    public function eliminar($id)
    {
        $data = ["id" => $id];
        $this->vistas("perfiles/eliminar", $data);
    }

    public function registrar()
    {
        $this->vistaSimple("perfiles/registrar");
    }
}
    
