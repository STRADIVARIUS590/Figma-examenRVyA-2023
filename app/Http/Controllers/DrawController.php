<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Draw;
use App\Models\User;

class DrawController extends Controller
{
    public $breadcrum_info = array(
        "main_title" => "Draws",
        "second_level" => "",
        "ref" => "draws"
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrum_info = $this->breadcrum_info;
        $draws = Draw::all();

        #return $draws;
        return view('draws.index', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user() ?? $request->user_id ?? User::find(1);

        !$request->has('user_id') ? $request->merge(['user_id' => $user->id ]) : null;
       
        !$request->has('image') ? $request->merge(['image' => json_encode(['canvas' => ['width' => 400, 'height' => 400], 'figures' => []])]) : null;
     
        !$request->has('name') ? $request->merge(['name' => "Proyecto (".(1 + $user->draws->count()) .")"]) : null;

        $draw = Draw::create($request->all());

        return redirect(action([DrawController::class, 'show'], ['id' => $draw->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $draw = Draw::find($id);

        $draw->image  = preg_replace('/\n/','' ,$draw->image);

        return view('draws.show', compact('draw'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $draw = Draw::first();

        return $this->jsonResponse("Registro consultado correctamente", $draw, Response::HTTP_OK, null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $draw = Draw::where('id', $request->id)->firstOrFail();

        $draw->update($request->all());

        return redirect()->back()->with('success', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $draw = Draw::where('id', $id)->firstOrFail();

        $draw->delete();

        return $this->jsonResponse("Registro Eliminado correctamente", null, Response::HTTP_OK, null);
    }
}