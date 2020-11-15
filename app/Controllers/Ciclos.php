<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class Ciclos extends Controller
{
	public function listar()
	{
		$this->vistaSimple("ciclos/listar");
	}

	public function registrar()
    {
        $this->vistaSimple("ciclos/registrar");
    }

	public function editar($id)
	{
		$data["id"] = $id;
		$this->vistas("ciclos/editar", $data);

	}

    public function eliminar($id)
    {
        $data = ["id" => $id];
        echo view("ciclos/eliminar", $data);
    }
    

}
