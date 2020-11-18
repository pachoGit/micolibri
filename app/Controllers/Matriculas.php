<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Matriculas extends Controller
{
    public function index()
    {
        $this->vistaSimple("reportes/matriculas");
    }
}
