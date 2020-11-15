<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MotivoPago extends Controller
{
    public function listar_motivo()
    {
        $this->vistaSimple("motivoPago/listar");
    }

    public function registrar()
    {
        $this->vistaSimple("motivoPago/registrar");
    }

    public function editar($id)
    {
        $data["id"] = $id;
        
        $this->vistas("motivoPago/editar", $data);
    }

    public function eliminar($id)
    {
        $data["id"] = $id;
        
        echo view("motivoPago/eliminar", $data);
    }
}
