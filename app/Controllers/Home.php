<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
        return view("login");
		//return view('welcome_message');
	}

    public function principal()
    {
        $this->vistaSimple("principal");
    }

    public function salir()
    {
        session_start();
        session_destroy();
        return redirect()->to(base_url());
    }

    public function cambiar()
    {
        $db = \Config\Database::connect();
        //$consulta = $db->query("ALTER TABLE AlumnoPorCurso RENAME COLUMN 'fechaCreacion' TO 'fechaCreacionM'");
        $consulta = $db->query("SELECT * from Usuarios");
        $resultado = $consulta->getResult();
        echo $resultado;
    }
	//--------------------------------------------------------------------

}
