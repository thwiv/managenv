<?php

namespace App\Http\Controllers;

use App\Environment;
use App\Http\Requests;
use App\Variable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $environment;
    private $variable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Environment $environment, Variable $variable)
    {
        $this->middleware('auth');
        $this->environment = $environment;
        $this->variable = $variable;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parents = $this->environment->whereNull('parent_id')->get();
        return view('home', ['environments' => $parents]);
    }

    public function getEnvironment($id = 0){

    }
}
