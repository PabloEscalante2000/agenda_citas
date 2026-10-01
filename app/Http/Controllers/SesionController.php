<?php

namespace App\Http\Controllers;

use App\Http\Resources\SesionResource;
use App\Models\Sesion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize("viewAny", Sesion::class);
        $sesiones = Sesion::visibleFor($request->user())
            ->with("patient")
            ->orderByDesc("start_time")
            ->paginate(15);
        
        return SesionResource::collection($sesiones);
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
    public function show(Sesion $sesion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sesion $sesion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sesion $sesion)
    {
        //
    }
}
