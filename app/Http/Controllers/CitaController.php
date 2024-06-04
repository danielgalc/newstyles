<?php

namespace App\Http\Controllers;

use App\Mail\CitaAceptada;
use App\Mail\CitaCancelada;
use App\Mail\CitaReservada;
use App\Models\BloqueoPeluquero;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use App\Rules\HoraValida;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::all();

        return view('citas.index', [
            'citas' => $citas,
        ]);
    }

    public function historial()
    {
        // Obtiene el usuario actualmente autenticado
        $user = auth()->user();

        // Obtiene la próxima cita activa (aceptada o pendiente)
        $proximaCitaActiva = Cita::where('user_id', $user->id)
            ->whereIn('estado', ['aceptada', 'pendiente'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->first();

        // Si no hay citas activas, obtiene la próxima cita inactiva (cancelada)
        $proximaCitaInactiva = null;
        if (!$proximaCitaActiva) {
            $proximaCitaInactiva = Cita::where('user_id', $user->id)
                ->where('estado', 'cancelada')
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->first();
        }

        // Obtiene todas las citas finalizadas o canceladas, ordenadas de más recientes a más antiguas
        $citasFinalizadas = Cita::where('user_id', $user->id)
            ->whereIn('estado', ['finalizada', 'cancelada'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->get();

        // Obtiene todos los peluqueros
        $users = User::where('rol', 'peluquero')->get();
        $servicios = Servicio::all();

        return view('citas.historial-citas', [
            'proximaCita' => $proximaCitaActiva ? $proximaCitaActiva : $proximaCitaInactiva,
            'citasFinalizadas' => $citasFinalizadas,
            'users' => $users,
            'servicios' => $servicios,
        ]);
    }

    public function cancelar(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'cancelada';
        $cita->save();

        // Enviar correo de cancelación
        Mail::to($cita->user->email)->send(new CitaCancelada($cita));

        return redirect()->route('historial-citas')->with('success', 'Cita cancelada con éxito.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cita = new Cita();
        $peluqueros = User::where('rol', 'peluquero')->get();

        $servicios = Servicio::all();

        // Obtener la ID de la URL
        $servicioId = $request->route('id');

        // Buscar el servicio por ID
        $servicio = $servicios->find($servicioId);

        return view('citas.create', [
            'cita' => $cita,
            'peluqueros' => $peluqueros,
            'servicio' => $servicio,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'user_id' => 'required|integer|exists:users,id',
             'peluquero_id' => 'required|integer|exists:users,id',
             'fecha' => 'required|date',
             'hora' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
             'servicio' => 'required|integer|exists:servicios,id',
         ], [
             'user_id.required' => 'El campo usuario es obligatorio.',
             'user_id.integer' => 'El ID del usuario debe ser un número entero.',
             'user_id.exists' => 'El usuario seleccionado no existe.',
             'peluquero_id.required' => 'El campo peluquero es obligatorio.',
             'peluquero_id.integer' => 'El ID del peluquero debe ser un número entero.',
             'peluquero_id.exists' => 'El peluquero seleccionado no existe.',
             'fecha.required' => 'La fecha es obligatoria.',
             'fecha.date' => 'La fecha no tiene un formato válido.',
             'hora.required' => 'La hora es obligatoria.',
             'hora.regex' => 'La hora debe tener el formato HH:MM o HH:MM:SS.',
             'servicio.required' => 'El campo servicio es obligatorio.',
             'servicio.integer' => 'El ID del servicio debe ser un número entero.',
             'servicio.exists' => 'El servicio seleccionado no existe.',
         ]);
     
         $hora = $request->input('hora');
         // Convertir "H:i" a "H:i:s" si es necesario
         if (preg_match('/^\d{2}:\d{2}$/', $hora)) {
             $hora .= ':00';
         }
     
         $cita = new Cita();
         $cita->user_id = $request->input('user_id');
         $cita->peluquero_id = $request->input('peluquero_id');
         $cita->fecha = $request->input('fecha');
         $cita->hora = $hora;
         $servicio = Servicio::findOrFail($request->input('servicio'));
         $cita->servicio = $servicio->nombre;
     
         // Verifica si el usuario que crea la cita es un administrador
         $user = $request->user();
         if ($user->rol == 'admin') {
             $cita->estado = 'aceptada';
             $cita->save();

            Mail::to($cita->user->email)->send(new CitaAceptada($cita));

     
             return redirect('/admin/citas')->with('success', 'Cita añadida con éxito.');
         }
     
         $cita->save();
     
         // Enviar correo de reserva de cita
         Mail::to($cita->user->email)->send(new CitaReservada($cita));
     
         return redirect('/historial-citas')->with('success', 'Cita añadida con éxito.');
     }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);

        return view('citas.edit', [
            'cita' => $cita,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'peluquero_id' => 'required|integer|exists:users,id',
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'servicio' => 'required|integer|exists:servicios,id',
            'estado' => 'required|in:pendiente,aceptada,cancelada,finalizada',
        ], [
            'user_id.required' => 'El campo usuario es obligatorio.',
            'user_id.integer' => 'El ID del usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'peluquero_id.required' => 'El campo peluquero es obligatorio.',
            'peluquero_id.integer' => 'El ID del peluquero debe ser un número entero.',
            'peluquero_id.exists' => 'El peluquero seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.regex' => 'La hora debe tener el formato HH:MM o HH:MM:SS.',
            'servicio.required' => 'El campo servicio es obligatorio.',
            'servicio.integer' => 'El ID del servicio debe ser un número entero.',
            'servicio.exists' => 'El servicio seleccionado no existe.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los siguientes: pendiente, aceptada, cancelada, finalizada.',
        ]);
    
        $hora = $request->input('hora');
        // Convertir "H:i" a "H:i:s" si es necesario
        if (preg_match('/^\d{2}:\d{2}$/', $hora)) {
            $hora .= ':00';
        }
    
        $cita = Cita::findOrFail($id);
    
        $estadoAnterior = $cita->estado;
    
        $cita->user_id = $request->input('user_id');
        $cita->peluquero_id = $request->input('peluquero_id');
        $cita->fecha = $request->input('fecha');
        $cita->hora = $hora;
        $servicio = Servicio::findOrFail($request->input('servicio'));
        $cita->servicio = $servicio->nombre;
        $cita->estado = $request->input('estado');
    
        $cita->save();
    
        // Enviar correo de aceptación solo si el nuevo estado es "aceptada"
        if ($estadoAnterior !== 'aceptada' && $cita->estado === 'aceptada') {
            Mail::to($cita->user->email)->send(new CitaAceptada($cita));
        }
    
        // Enviar correo de cancelación solo si el nuevo estado es "cancelada"
        if ($estadoAnterior !== 'cancelada' && $cita->estado === 'cancelada') {
            Mail::to($cita->user->email)->send(new CitaCancelada($cita));
        }
    
        return redirect('/admin/citas')
            ->with('success', 'Cita modificada con éxito.');
    }
    

    public function updateFromHistorial(Request $request, string $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'peluquero_id' => 'required|integer|exists:users,id',
            'fecha' => 'required|date',
            'hora' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
            'servicio' => 'required|integer|exists:servicios,id',
        ], [
            'peluquero_id.required' => 'El campo peluquero es obligatorio.',
            'peluquero_id.integer' => 'El ID del peluquero debe ser un número entero.',
            'peluquero_id.exists' => 'El peluquero seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.regex' => 'La hora debe tener el formato HH:MM o HH:MM:SS.',
            'servicio.required' => 'El campo servicio es obligatorio.',
            'servicio.integer' => 'El ID del servicio debe ser un número entero.',
            'servicio.exists' => 'El servicio seleccionado no existe.',
        ]);
    
        $hora = $request->input('hora');
        if (preg_match('/^\d{2}:\d{2}$/', $hora)) {
            $hora .= ':00';
        }
    
        $cita = Cita::findOrFail($id);
        $cita->peluquero_id = $request->input('peluquero_id');
        $cita->fecha = $request->input('fecha');
        $cita->hora = $hora;
        $cita->estado = 'pendiente';
        $servicio = Servicio::findOrFail($request->input('servicio'));
        $cita->servicio = $servicio->nombre;

        $cita->save();
    
        Mail::to($cita->user->email)->send(new CitaReservada($cita));

        return redirect()->route('historial-citas')->with('success', 'Cita modificada con éxito.');
    }
    


    public function buscarUsuarios(Request $request)
    {
        $query = $request->get('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('id', 'like', "%{$query}%")
            ->orderBy('id')
            ->get(['id', 'name']);

        return response()->json($users);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);

        // Enviar correo de cancelación
        Mail::to($cita->user->email)->send(new CitaCancelada($cita));

        $cita->delete();

        return redirect('/admin/citas')
            ->with('success', 'Cita eliminada con éxito.');
    }

    public function actualizar_estado(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);
    
        $estadoAnterior = $cita->estado;
    
        // Actualiza solo el estado de la cita
        $cita->estado = $request->input('estado');
        $cita->save();
    
        // Enviar correo de aceptación solo si el nuevo estado es "aceptada"
        if ($estadoAnterior !== 'aceptada' && $cita->estado === 'aceptada') {
            Mail::to($cita->user->email)->send(new CitaAceptada($cita));
        }
    
        // Enviar correo de cancelación solo si el nuevo estado es "cancelada"
        if ($estadoAnterior !== 'cancelada' && $cita->estado === 'cancelada') {
            Mail::to($cita->user->email)->send(new CitaCancelada($cita));
        }
    
        return redirect()->back()->with('success', 'Estado de la cita actualizado con éxito.');
    }
    

    /**
     * Funciones del usuario peluquero
     */

     public function obtenerCitas(Request $request): JsonResponse
     {
         $peluqueroId = $request->query('peluquero_id');
         $fecha = $request->query('fecha');
     
         $citas = Cita::where('peluquero_id', $peluqueroId)
             ->whereDate('fecha', $fecha)
             ->whereIn('estado', ['aceptada', 'pendiente'])
             ->get();
     
         $bloqueos = BloqueoPeluquero::where('peluquero_id', $peluqueroId)
             ->whereDate('fecha', $fecha)
             ->get();
     
         return response()->json([
             'citas' => $citas,
             'bloqueos' => $bloqueos,
         ]);
     }   


    public function gestionarCitas()
    {
        $user = Auth::user();

        if ($user->rol != 'peluquero' || !str_ends_with($user->email, '@peluquero.com')) {
            return redirect()->route('home');
        }

        $citasPendientes = Cita::where('peluquero_id', $user->id)->where('estado', 'pendiente')->get();
        $citasAceptadas = Cita::where('peluquero_id', $user->id)->where('estado', 'aceptada')->get();

        // Debugging
        // dd($citasPendientes, $citasAceptadas);

        return view('peluquero.citas', compact('citasPendientes', 'citasAceptadas'));
    }

    public function aceptarCita($id)
    {
        $cita = Cita::find($id);
        $peluqueroId = Auth::id();
    
        if ($cita->peluquero_id != $peluqueroId || $cita->estado != 'pendiente') {
            return redirect()->back();
        }
    
        DB::transaction(function () use ($cita, $peluqueroId) {
            Cita::where('peluquero_id', $peluqueroId)
                ->where('fecha', $cita->fecha)
                ->where('hora', $cita->hora)
                ->where('estado', 'pendiente')
                ->update(['estado' => 'cancelada']);
    
            $cita->estado = 'aceptada';
            $cita->save();
        });
    
        // Enviar correo de aceptación
        Mail::to($cita->user->email)->send(new CitaAceptada($cita));
    
        return redirect()->route('peluquero.citas');
    }
    

    public function cancelarCita($id)
    {
        $cita = Cita::find($id);
        $peluqueroId = Auth::id();

        if ($cita->peluquero_id != $peluqueroId || ($cita->estado != 'pendiente' && $cita->estado != 'aceptada')) {
            return redirect()->back();
        }

        $cita->estado = 'cancelada';
        $cita->save();

        // Enviar correo de cancelación
        Mail::to($cita->user->email)->send(new CitaCancelada($cita));

        return redirect()->route('peluquero.citas');
    }
}
