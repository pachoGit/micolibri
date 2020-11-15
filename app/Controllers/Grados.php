<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
class Grados extends Controller
{
	public function listar()
	{
		
		$this->vistaSimple("grados/listar");
	}
	public function registrar()
    {
        $this->vistaSimple("grados/registrar");
    }
	public function editar($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("grados/editar", $data);

	}
	 public function eliminar($id)
    {
        $data = ["id" => $id];
        echo view("grados/eliminar", $data);
    }

	
}
