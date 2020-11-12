<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AlumnoPorCurso extends Controller
{
    public function listar()
    {
        $this->vistaSimple("matriculas/alumnos/listar");
    }

    public function registrar()
    {
        $this->vistaSimple("matriculas/alumnos/registrar");
    }

    public function ver($id)
    {
        $data = ["id" => $id];
        $this->vistas("matriculas/alumnos/ver", $data);
    }
    
}
