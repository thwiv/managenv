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

    public function addEnvironment(Request $r, $parent = null){
        $name = $r->input('name');
        try{
            $count = $this->environment->where('name', '=', $name)->count();
            if($count > 0){
                return response()->json(['success'=>false, 'error'=>'Name Must Be Unique']);
            }
            else{
                $env = new Environment();
                $env->name = $name;
                $env->parent_id = $parent;
                $env->save();
                return response()->json(['success'=>true, 'id'=>$env->id]);
            }
        }
        catch(\Exception $ex){
            return response()->json(['success'=>false, 'error'=>$ex->getMessage()]);
        }

    }

    public function getEnvironment($id){
        $env = $this->environment->find($id);
        if($env){
            $var_list = $env->fullVariableList();
            return view('environment', ['env'=>$env, 'vars' => $var_list]);
        }
        abort(404);
    }
}
