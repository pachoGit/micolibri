<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CurSecPorProfesor extends Controller
{
    public function listar()
    {
        $this->vistaSimple("matriculas/profesores/listar");
    }

    public function registrar()
    {
        $this->vistaSimple("matriculas/profesores/registrar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("matriculas/profesores/ver", $data);
    }
    
    public function eliminar($id)
    {
        $data = ["id" => $id];
        echo view("matriculas/profesores/eliminar", $data);
    }
}
