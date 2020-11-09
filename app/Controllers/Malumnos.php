<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Malumnos extends Controller
{
    public function index()
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
