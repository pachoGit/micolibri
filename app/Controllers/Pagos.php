<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class Pagos extends Controller
{
    // Controlar las vistas de los pagos de alumnos

	public function listar_alumnos()
	{
		$this->vistaSimple("pagos/alumnos/listar");
	}

	public function registrar_alumno()
    {
        $this->vistaSimple("pagos/alumnos/registrar");
    }

	public function editar_alumno($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("pagos/alumnos/editar", $data);
	}

	public function ver_alumno($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("pagos/alumnos/ver", $data);
	}

    public function eliminar_alumno($id)
    {
        $data = ["id" => $id];
        echo view("pagos/alumnos/eliminar", $data);
    }

    // Controlar las vistas de los pagos a profesores

    public function listar_profesores()
    {
        $this->vistaSimple("pagos/profesores/listar");
    }

	public function registrar_profesor()
    {
        $this->vistaSimple("pagos/profesores/registrar");
    }

	public function ver_profesor($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("pagos/profesores/ver", $data);
	}

	public function editar_profesor($id)
	{
		$data = array("id"=>$id);	
		$this->vistas("pagos/profesores/editar", $data);
	}

    public function eliminar_profesor($id)
    {
        $data = ["id" => $id];
        echo view("pagos/profesores/eliminar", $data);
    }

}
