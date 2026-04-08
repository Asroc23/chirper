<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChirpController extends Controller
{
    // Incluir el trait AuthorizesRequests para manejar la autorización de acciones
    use AuthorizesRequests;

    //Método para mostrar la vista de inicio
    public function index()
    {
       $chirps = Chirp::with('user')
            ->latest()
            ->take(50) //Obtener los últimos 50 chirps con su usuario asociado
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        // Validar la entrada del usuario
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        // Crear un nuevo chirp asociado al usuario autenticado
        auth()->user()->chirps()->create($validated);
    
        return redirect('/')->with('success', '¡Tu chirrido ha sido publicado!');
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(Chirp $chirp)
    {
        // Verificar si el usuario tiene permiso para editar el chirp
        $this->authorize('update', $chirp);
 
        return view('chirps.edit', compact('chirp'));
    }

   
    public function update(Request $request, Chirp $chirp)
    {
        // Verificar si el usuario tiene permiso para actualizar el chirp
        $this->authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
    
        $chirp->update($validated);
    
        return redirect('/')->with('success', 'Chirp updated!');
    }

   
    public function destroy(Chirp $chirp)
    {
        // Verificar si el usuario tiene permiso para eliminar el chirp
        $this->authorize('delete', $chirp);
 
        $chirp->delete();
    
        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
