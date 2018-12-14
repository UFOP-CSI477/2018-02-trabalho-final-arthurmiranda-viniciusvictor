<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Action;
use App\Baby;

class ActionController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            $sidebar_selected = 0;
            $user_id = Auth::user()->id;
            $actions = DB::table('actions')
                        ->join('babies', 'actions.baby_id', '=', 'babies.id')
                        ->join('users', 'users.id', '=', 'babies.parent_id')
                        ->where('users.id', $user_id)
                        ->orderBy('actions.date', 'desc')
                        ->select('actions.*', 'babies.name')
                        ->get();
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');
            return view('home', compact('actions', 'babies', 'sidebar_selected'));
        } else
            return view('home');
    }
  
    public function create()
    {
        if (Auth::check()) 
        {
            $sidebar_selected = 3;
            $user_id = Auth::user()->id;
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');
            return view('home', compact('babies', 'sidebar_selected'));
        }
    }
  
    public function store(Request $request)
    {
        $request->validate(
            ['baby_id'=>'required|integer',
            'type'=>'required|integer',
            'description'=>'required|max:191',
            'date'=>'required|date']);
        $action = new Action(
            ['baby_id' => $request->get('baby_id'),
            'type' => $request->get('type'),
            'description'=> $request->get('description'),
            'date'=>$request->get('date')]);
        $action->save();
        return redirect('/')->with('success', 'Atividade cadastrada com sucesso');
    }
    
    public function edit($id)
    {
        if (Auth::check()) 
        {
            $sidebar_selected = 3;
            $user_id = Auth::user()->id;
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');
            $action = Action::findOrFail($id);
            return view('home', compact('action', 'babies', 'sidebar_selected'));
        }
    }
  
    public function update(Request $request, $id)
    {
        $action = Action::findOrFail($id);
        $action->baby_id = $request->baby_id;
        $action->type = $request->type;
        $action->description = $request->description;
        $action->date = $request->date;
        $action->save();
        return redirect('/')->with('success', 'Atividade atualizada com sucesso');
    }
  
    public function destroy($id)
    {
        $action = Action::findOrFail($id);
        $action->delete();
        return redirect('/')->with('success', 'Informações do bebê excluídas com sucesso');
    }

    public function search(Request $request) {
        $user_id = Auth::user()->id;
        $baby_id = $request->get('baby_id');
        $date = $request->get('date');
        $info = ['baby_id' => $baby_id, 'date' => $date];
        $sidebar_selected = 0;

        if ($baby_id != -1 && $date != '') {
            $actions = DB::table('actions')
                        ->join('babies', 'actions.baby_id', '=', 'babies.id')
                        ->where('actions.baby_id', $baby_id)
                        ->whereDate('actions.date', $date)
                        ->orderBy('actions.date', 'desc')
                        ->select('actions.*', 'babies.name')
                        ->get();
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');

            return view('home', compact('actions', 'info', 'babies', 'sidebar_selected'));
        } else if ($baby_id != -1) {
            $actions = DB::table('actions')
                        ->join('babies', 'actions.baby_id', '=', 'babies.id')
                        ->where('babies.id', $baby_id)
                        ->orderBy('actions.date', 'desc')
                        ->select('actions.*', 'babies.name')
                        ->get();
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');

            return view('home', compact('actions', 'info', 'babies', 'sidebar_selected'));
        } else if ($date != '') {
            $actions = DB::table('actions')
                        ->join('babies', 'actions.baby_id', '=', 'babies.id')
                        ->join('users', 'users.id', '=', 'babies.parent_id')
                        ->where('users.id', $user_id)
                        ->whereDate('actions.date', $date)
                        ->orderBy('actions.date', 'desc')
                        ->select('actions.*', 'babies.name')
                        ->get();
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');

            return view('home', compact('actions', 'info', 'babies', 'sidebar_selected'));
        } else {
            $actions = DB::table('actions')
                        ->join('babies', 'actions.baby_id', '=', 'babies.id')
                        ->join('users', 'users.id', '=', 'babies.parent_id')
                        ->where('users.id', $user_id)
                        ->orderBy('actions.date', 'desc')
                        ->select('actions.*', 'babies.name')
                        ->get();
            $babies = Baby::all()->where('parent_id', $user_id)->sortByDesc('birthday');
            return view('home', compact('actions', 'babies', 'sidebar_selected'));
        }
    }
}
