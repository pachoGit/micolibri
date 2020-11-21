<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Notas extends Controller
{
    public function index()
    {
        $this->vistaSimple("notas/listar");
    }

    public function ver($id)
    {
        $this->vistas("notas/ver", ["id" => $id]);
    }
}
