<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Cursos extends Controller
{
    public function listar()
    {
        $this->vistaSimple("cursos/listar");
    }

    public function registrar()
    {
        $this->vistaSimple("cursos/registrar");
    }
    
    public function editar($id)
    {
        $data["id"] = $id;

        $this->vistas("cursos/editar", $data);
    }

    public function eliminar($id)
    {
        $data["id"] = $id;
        
        echo view("cursos/eliminar", $data);
    }
}
