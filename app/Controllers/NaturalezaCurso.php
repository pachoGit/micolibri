<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class NaturalezaCurso extends Controller{

	public function crear()
    {
        $solicitud = \Config\Services::request();

        $data = ["naturaleza" => $solicitud->getVar("naturaleza")];
        return view("naturalezaCurso/registrar", $data);
    }
}
