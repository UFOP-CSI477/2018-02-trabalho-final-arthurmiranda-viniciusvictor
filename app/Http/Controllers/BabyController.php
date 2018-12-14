<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Baby;

class BabyController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            $sidebar_selected = 1;
            $user_id = Auth::user()->id;
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');
            return view('home', compact('babies', 'sidebar_selected'));
        }
    }
  
    public function create()
    {
        $sidebar_selected = 2;
        return view('home', compact('sidebar_selected'));
    }

    public function store(Request $request)
    {
        if (Auth::check()) 
        {
            $user_id = Auth::user()->id;
            $request->validate(
                ['name'=>'required|max:191',
                'birthday'=>'required|date',
                'sex'=>'required|max:1']);
            $baby = new Baby(
                ['id' => $request->get('id'),
                'parent_id' => $user_id,
                'name'=> $request->get('name'),
                'birthday'=>$request->get('birthday'),
                'sex'=>$request->get('sex')]);
            $baby->save();
            return redirect('/babies')->with('success', 'Equipamento cadastrado com sucesso');
        }
    }

    public function edit($id)
    {
        $sidebar_selected = 2;
        $baby = Baby::findOrFail($id);
        return view('home', compact('baby', 'sidebar_selected'));
    }
  
    public function update(Request $request, $id)
    {
        $baby = Baby::findOrFail($id);
        $baby->name = $request->name;
        $baby->birthday = $request->birthday;
        $baby->sex = $request->sex;
        $baby->save();
        return redirect('/babies')->with('success', 'Bebê atualizado com sucesso');
    }
  
    public function destroy($id)
    {
        $baby = Baby::findOrFail($id);
        $baby->delete();
        return redirect('/babies')->with('success', 'Informações do bebê excluídas com sucesso');
    }
}
