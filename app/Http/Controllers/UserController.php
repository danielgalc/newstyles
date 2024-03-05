<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $users = User::all()->where('id', Auth::user()->id)->first();
        return view('perfil.index', [
            'users' => $users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();

        return view('users.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->rol = $request->input('rol', 'cliente'); // Valor por defecto si no se proporciona

        $user->save();

        return redirect('/users')
            ->with('success', 'Usuario añadido con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
    
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->rol = $request->input('rol', 'cliente');
    
        // Verificamos si se proporcionó una nueva contraseña 
        if ($request->filled('password')) {
            // Si es así, encriptamos la contraseña
            $user->password = bcrypt($request->input('password'));
        }
    
        $user->save();
    
        return redirect('/users')
            ->with('success', 'Usuario modificado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/users')
            ->with('success', 'Usuario eliminado con éxito.');
    }
}
