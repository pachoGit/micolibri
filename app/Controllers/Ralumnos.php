<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Ralumnos extends Controller
{
    public function index()
    {
        $this->vistaSimple("reportes/alumnos");
    }

}
