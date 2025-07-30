<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes =Employe ::orderBy('id')->paginate();
        return view('dashboard',compact('employes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employe = Employe::findOrFail($id);
        return view('employes.edit', compact('employe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
          $employe = Employe::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|max:255',
            'email' => "sometimes|email|unique:users,email,{$employe->id}",
        ]);

        $employe->update($validated);

        return redirect()->route('employes.index')->with('success', 'employe mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);

    $employe->delete();

    return redirect()->back()->with('success', 'Employé supprimé avec succès.');
    }


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


}
