<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(){
        return view('cursos.index');
    }
    public function allData(){
        $data = Curso::orderBy('id','desc')->get();//->paginate(8);
        return response()->json([
            'datos' =>$data,
            'success' => true
        ]);
    }
    public function create(Request $request){
       /* $data = Curso::insert([
            'name' => $request->name,
            'description' => $request->descripcion,
            'categoria' => $request->categoria,
        ]);*/
        $curso = new Curso();
        $name=$request->name;
        $curso->name = $request->name;
        $curso->description = $request->descripcion;
        $curso->categoria = $request->categoria;
        $curso->slug = Str::slug($name,'_');
        $curso->save();
        return response()->json($curso); 
    }
    public function destroy(Curso $curso){
        $curso->delete();
        return response()->json($curso); 
    }
}
