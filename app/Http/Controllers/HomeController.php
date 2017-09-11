<?php
namespace App\Http\Controllers;

use App\Environment;
use App\Variable;
use Illuminate\Http\Request;

class HomeController extends Controller
{

	/** @var Environment */
    private $environment;
    private $variable;

	/**
	 * HomeController constructor.
	 *
	 * @param Environment $environment
	 * @param Variable $variable
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
        return null;
    }
    public function setVariable(Request $r, $environment_id){
        $name = strtoupper($r->input('name'));
        $value = $r->input('value');
        $var = $this->variable->where('environment_id', '=', $environment_id)->where('name', '=', $name)->first();
        $new = false;
        if(empty($var)){
            $var = new Variable();
            $var->environment_id = $environment_id;
            $var->name = strtoupper($name);
            $new = true;
        }
        $var->value = $value;
        $var->save();
        return response()->json([
            'success'=>true,
            'id'=>$var->id,
            'new'=>$new,
            'html'=> view('partials.var-row', ['var'=>$var, 'show_delete'=>true])->render()
        ]);
    }
    public function deleteVariable(Request $r){
        $id = $r->input('id');
        $env_id = $r->input('environment');
        $var = $this->variable->where('environment_id', '=', $env_id)->where('id', '=', $id)->first();
        $env = $this->environment->find($env_id);
        $parent_var = null;
        if(!empty($var)){
            $parent_var = $env->firstParentValue($var->name);
            $var->delete();
            if(!empty($parent_var)){
                return response()->json(['success'=>true,
                        'parent_html'=> view('partials.var-row', ['var'=>$parent_var, 'show_delete'=>false])->render()]
                );
            }
            return response()->json(['success'=>true, 'parent_html'=>null]);
        }
        return response()->json(['success'=>false, 'parent_html'=>null]);
    }
    public function export(Request $r, $id){
        $env = $this->environment->find($id);
        if(!empty($env)){
            $content = $env->fileContent();

            return response($content, 200, [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment; filename="'.$env->name.'.env"'
            ]);
        }
        abort(500);
        return null;
    }

}
