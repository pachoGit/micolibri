<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Sesiones extends Controller
{
    public function index()
    {
        $this->vistaSimple("sesiones/listar");
    }
}
