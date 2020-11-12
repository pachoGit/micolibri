<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Usuarios extends Controller
{
    public function listar()
    {
        $this->vistaSimple("usuarios/listar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("usuarios/ver", $data);
    }

    public function editar($id)
    {
        $data = ["id" => $id];
        $this->vistas("usuarios/editar", $data);
    }

    public function eliminar($id)
    {
        $data = ["id" => $id];
        $this->vistas("usuarios/eliminar", $data);
    }

    public function registrar()
    {
        $this->vistaSimple("usuarios/registrar");
    }
}
    
