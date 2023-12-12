<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentController extends Controller
{
    public function index()
    {
        $departaments = Departament::all();
        return Inertia::render('Departaments/Index', ['departaments' => $departaments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Departaments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100']);
        // $departament = new Departament($request->input());
        // $departament->save();
        Departament::create($request->all());
        // return redirect('departaments');
        return redirect(route('departaments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        // return Inertia::render('Departaments/Show', ['departament' => $departament]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departament $departament)
    {
        return Inertia::render('Departaments/Edit', ['departament' => $departament]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        $request->validate(['name' => 'required|max:100']);
        $departament->update($request->all());
        return redirect('departaments');
        // return redirect('departaments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        $departament->delete();
        return redirect(route('departaments.index'));
    }
}
