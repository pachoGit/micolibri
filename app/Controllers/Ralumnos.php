<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Ralumnos extends Controller
{
    public function index()
    {
        helper("pdf");
        $this->vistaSimple("reportes/alumnos");
    }

}
