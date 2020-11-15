<?php 
namespace App\Controllers;
use CodeIgniter\Controller;
class Sedes extends Controller
{
	public function listar()
	{
		$this->vistaSimple("sedes/listar");
	}
	public function registrar()
    {
        $this->vistaSimple("sedes/registrar");
    }
	public function editar($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("sedes/editar", $data);

	}
	 public function eliminar($id)
    {
        $data = ["id" => $id];
        echo view("sedes/eliminar", $data);
    }
    

}
