<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Rprofesores extends Controller
{
    public function index()
    {
        $this->vistaSimple("reportes/profesores");
    }

}
