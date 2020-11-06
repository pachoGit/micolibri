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

	//--------------------------------------------------------------------

}
