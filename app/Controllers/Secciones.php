<?php  
namespace App\Controllers;
use CodeIgniter\Controller;
class Secciones extends Controller{
	public function listar(){
		$this->vistaSimple("secciones/listar");
	}
	public function registrar(){
		$this->vistaSimple("secciones/registrar");
	}
	public function editar($id){
		$data = array("id"=>$id);
		$this->vistas("secciones/editar",$data);
	}
	public function eliminar($id){
		$data = ["id" => $id];
        echo view("secciones/eliminar", $data);
	}
}
