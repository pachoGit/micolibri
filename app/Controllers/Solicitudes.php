<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Solicitudes extends Controller
{
    public function listar()
    {
        $this->vistaSimple("solicitudes/listar");
    }
}

