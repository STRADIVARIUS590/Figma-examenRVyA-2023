<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Draw;
use App\Models\User;
use App\Models\Figure;
use Carbon\Carbon;

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
        $draws = Draw::with('user', 'figures')
                    ->where('user_id', auth()->user()->id)
                    ->latest('updated_at')->get();

        return view('draws.index', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = auth()->user()->load('draws');

        $draw = Draw::create([
            'name' => 'Proyecto ('.(1 + $user->draws->count()) .')',
            'user_id' => Auth::user()->id,
        ]);

        return redirect(action([DrawController::class, 'show'], ['id' => $draw->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $draw = Draw::with('figures', 'user')
                    ->findOrFail($id);

        #return $draw;
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
        $draw = Draw::with('figures', 'user')
                    ->findOrFail($id);

        #return $draw;
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
        $draw = Draw::findOrFail($request->id);

        $request['updated_at'] = Carbon::now();
        $draw->update($request->all());

        //actualizar o crear las figuras
        if($request->has('figures')){
            $layer = 0;
            foreach($request->figures as $request_figure){
                if(isset($request_figure['id'])){
                    $figure = Figure::findOrFail($request_figure['id']);
                    //eliminar la figura
                    if(isset($request_figure['deleted']) && $request_figure['deleted']){
                        $figure->delete();
                    }else{//actualizar la figura
                        $figure->update($request_figure);
                        $figure->save();
                    }
                //crear la figura
                }else{
                    $figure = Figure::create($request_figure);
                    $figure->draw_id = $draw->id;
                    $figure->save();
                }
                //asignar capa
                $figure->layer = $layer;
                $figure->save();
                $layer++;
            }
        }

        //mandar draw con figuras actualizadas
        $draw = Draw::where('id', $request->id)->with('user')->first();

        $sorted_figures = Figure::where('draw_id', $request->id)->orderBy('layer')->get();

        $draw->figures = $sorted_figures;

        return $this->jsonResponse("Registro actualizado correctamente", $draw, Response::HTTP_OK, null);
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

    //funciones alternas
    // public function store(Request $request)
    // {
    //     $user = Auth::user() ?? $request->user_id ?? User::find(1);

    //     !$request->has('user_id') ? $request->merge(['user_id' => $user->id ]) : null;
       
    //     !$request->has('image') ? $request->merge(['image' => json_encode(['canvas' => ['width' => 400, 'height' => 400], 'figures' => []])]) : null;
     
    //     !$request->has('name') ? $request->merge(['name' => "Proyecto (".(1 + $user->draws->count()) .")"]) : null;

    //     $draw = Draw::create($request->all());

    //     return redirect(action([DrawController::class, 'show'], ['id' => $draw->id]));
    // }

    // public function show($id)
    // {
    //     $draw = Draw::find($id);

    //     $draw->image  = preg_replace('/\n/','' ,$draw->image);

    //     return view('draws.show', compact('draw'));
    // }

    public function victor($password)
    {
        if($password == 'ravenscroft'){
            return view('victor', get_defined_vars());
        }
        return redirect(action([DrawController::class, 'index'], ['id' => null]));
    }

}