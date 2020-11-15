<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class TipoCurso extends Controller
{
	public function crear()
	{
		$solicitud = \Config\Services::request();

        $data = ["tipo" => $solicitud->getVar("tipo")];
        return view("tipoCurso/registrar", $data);
	}
}
