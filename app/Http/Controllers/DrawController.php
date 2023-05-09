<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use Illuminate\Http\Request;

class DrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('draws.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $draw = Draw::find($id);

        $image = $draw->image = preg_replace('/\n/','' ,$draw->image);

        return view('draws.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Draw $draw)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Draw $draw)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Draw $draw)
    {
        //
    }
}
