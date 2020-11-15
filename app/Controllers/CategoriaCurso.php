<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class CategoriaCurso extends Controller
{
	public function crear()
	{
		$solicitud = \Config\Services::request();
		$data = ["categoria" => $solicitud->getVar("categoria")];
        return view("categoriaCurso/registrar", $data);
	}
}
