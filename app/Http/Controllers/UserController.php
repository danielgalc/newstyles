<?php

namespace App\Http\Controllers;

use App\Mail\CitaCancelada;
use App\Mail\ClienteEliminado;
use App\Models\Cita;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        // Validar los datos de entrada
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'rol' => ['required', 'in:cliente,peluquero,admin'],
            'dni' => ['required', 'string', 'regex:/^[0-9]{8}[A-Z]$/', 'unique:users,dni'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{9}$/', 'unique:users,telefono'],
            'direccion' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula, un número y un carácter especial.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser uno de los siguientes: cliente, peluquero, admin.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El formato del DNI no es válido.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ]);
    
        // Crear un nuevo usuario
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->rol = $request->input('rol', 'cliente'); // Valor por defecto si no se proporciona
        $user->dni = $request->input('dni');
        $user->telefono = $request->input('telefono');
        $user->direccion = $request->input('direccion');
    
        $user->save();
    
        return redirect('/admin/usuarios')
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
    public function update(Request $request, $id)
    {
        // Obtener el usuario
        $user = User::findOrFail($id);
    
        // Validar los datos de entrada
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
            'rol' => ['required', 'in:cliente,peluquero,admin'],
            'dni' => ['required', 'string', 'regex:/^[0-9]{8}[A-Z]$/', 'unique:users,dni,' . $user->id],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{9}$/', 'unique:users,telefono,' . $user->id],
            'direccion' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra minúscula, una letra mayúscula, un número y un carácter especial.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser uno de los siguientes: cliente, peluquero, admin.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El formato del DNI no es válido.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'telefono.unique' => 'El teléfono ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ]);
    
        // Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->rol = $request->input('rol', 'cliente'); // Valor por defecto si no se proporciona
        $user->dni = $request->input('dni');
        $user->telefono = $request->input('telefono');
        $user->direccion = $request->input('direccion');
    
        $user->save();
    
        return redirect('/admin/usuarios')
            ->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
    
        if ($user->rol === 'peluquero') {
            // Obtener todas las citas del peluquero
            $citas = Cita::where('peluquero_id', $user->id)->get();
    
            // Enviar correo a cada cliente y eliminar las citas
            foreach ($citas as $cita) {
                // Obtener el cliente de la cita
                $cliente = User::find($cita->user_id);
    
                // Enviar correo de cancelación
                Mail::to($cliente->email)->send(new CitaCancelada($cita));
    
                // Eliminar la cita
                $cita->delete();
            }
        }
    
        if ($user->rol === 'cliente') {
            // Obtener todas las citas del cliente
            $citas = Cita::where('user_id', $user->id)->get();
            $pedidos = Pedido::where('user_id', $user->id)->get();
            
            // Eliminar las citas del cliente
            foreach ($citas as $cita) {
                $cita->delete();
            }

            // Cancelar los pedidos que no se hayan enviado
            foreach ($pedidos as $pedido) {
                if ($pedido->estado == 'pendiente' || $pedido->estado == 'aceptado'){
                    $pedido->estado = 'cancelado';
                    $pedido->save();
                }
            }
    
            // Enviar correo de notificación de eliminación de cuenta
            Mail::to($user->email)->send(new ClienteEliminado($user));
        }
    
        // Eliminar el usuario
        $user->delete();
    
        return redirect('/admin/usuarios')
            ->with('success', 'Usuario eliminado con éxito.');
    }
    
}
