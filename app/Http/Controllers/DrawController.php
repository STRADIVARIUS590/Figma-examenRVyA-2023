<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Draw;

class drawController extends Controller
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

        #return $draw;
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
        $draw = Draw::create($request->all());
        
        return redirect()->back()->with('success', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $draw = Draw::find($id);

        $image = $draw->image = preg_replace('/\n/','' ,$draw->image);

        return view('draws.show', get_defined_vars());
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