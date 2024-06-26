<?php

namespace App\Http\Controllers;

use App\Mail\CitaCancelada;
use Illuminate\Http\Request;
use App\Models\BloqueoPeluquero;
use App\Models\Cita;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class BloqueoPeluqueroController extends Controller
{
    public function index()
    {
        $bloqueos = BloqueoPeluquero::with('peluquero')->paginate(10);
        $peluqueros = User::where('rol', 'peluquero')->get();

        return view('admin.bloqueos.bloqueos', compact('bloqueos', 'peluqueros'));
    }


    public function update(Request $request, $id)
    {
        $bloqueo = BloqueoPeluquero::findOrFail($id);
        $bloqueo->update([
            'peluquero_id' => $request->peluquero_id,
            'fecha' => $request->fecha,
            'horas' => json_encode($request->horas),
        ]);

        return redirect()->route('admin.bloqueos')->with('success', 'Bloqueo actualizado con éxito.');
    }


    public function destroy($id)
    {
        $bloqueo = BloqueoPeluquero::findOrFail($id);
        $bloqueo->delete();

        return redirect()->route('admin.bloqueos')->with('success', 'Bloqueo eliminado con éxito.');
    }


    public function store(Request $request)
    {
        $userId = $request->user_id;
        $horas = $request->horas;

        $bloqueoExistente = BloqueoPeluquero::where('peluquero_id', $userId)
            ->where('fecha', $request->fecha)
            ->first();

        if ($bloqueoExistente) {
            $horasExistentes = json_decode($bloqueoExistente->horas, true);
            $horasDuplicadas = array_intersect($horasExistentes, $horas);

            if (!empty($horasDuplicadas)) {
                // Crear un nuevo array para almacenar las horas formateadas
                $horasDuplicadasFormateadas = [];

                foreach ($horasDuplicadas as $hora) {
                    // Parsear la hora con Carbon
                    $horaCarbon = Carbon::parse($hora);
                    // Formatear la hora a H:i
                    $horaFormateada = $horaCarbon->format('H:i');
                    // Añadir la hora formateada al nuevo array
                    $horasDuplicadasFormateadas[] = $horaFormateada;
                }

                return back()->withErrors(['Las siguientes horas ya están bloqueadas: ' . implode(', ', $horasDuplicadasFormateadas)]);
            }

            $horas = array_merge($horasExistentes, $horas);
        }

        DB::transaction(function () use ($userId, $request, $horas, &$bloqueoExistente) {
            foreach ($horas as $hora) {
                $citas = Cita::where('peluquero_id', $userId)
                    ->where('fecha', $request->fecha)
                    ->where('hora', $hora)
                    ->whereIn('estado', ['aceptada', 'pendiente'])
                    ->get();

                foreach ($citas as $cita) {
                    $cita->estado = 'cancelada';
                    $cita->save();

                    // Enviar correo de cancelación
                    Mail::to($cita->user->email)->send(new CitaCancelada($cita));
                }
            }

            if ($bloqueoExistente) {
                $bloqueoExistente->horas = json_encode($horas);
                $bloqueoExistente->save();
            } else {
                BloqueoPeluquero::create([
                    'peluquero_id' => $userId,
                    'fecha' => $request->fecha,
                    'horas' => json_encode($horas),
                ]);
            }
        });

        return back()->with('success', 'Bloqueo creado con éxito.');
    }

    public function storeAdmin(Request $request)
    {
        $peluqueroId = $request->peluquero_id; // Cambiado de user_id a peluquero_id

        $horas = $request->horas;

        $bloqueoExistente = BloqueoPeluquero::where('peluquero_id', $peluqueroId)
            ->where('fecha', $request->fecha)
            ->first();

        if ($bloqueoExistente) {
            $horasExistentes = json_decode($bloqueoExistente->horas, true);
            $horasDuplicadas = array_intersect($horasExistentes, $horas);

            if (!empty($horasDuplicadas)) {
                return back()->withErrors(['Las siguientes horas ya están bloqueadas: ' . implode(', ', $horasDuplicadas)]);
            }

            $horas = array_merge($horasExistentes, $horas);
        }

        DB::transaction(function () use ($peluqueroId, $request, $horas, &$bloqueoExistente) {
            foreach ($horas as $hora) {
                $citas = Cita::where('peluquero_id', $peluqueroId)
                    ->where('fecha', $request->fecha)
                    ->where('hora', $hora)
                    ->whereIn('estado', ['aceptada', 'pendiente'])
                    ->get();

                foreach ($citas as $cita) {
                    $cita->estado = 'cancelada';
                    $cita->save();

                    // Enviar correo de cancelación
                    Mail::to($cita->user->email)->send(new CitaCancelada($cita));
                }
            }

            if ($bloqueoExistente) {
                $bloqueoExistente->horas = json_encode($horas);
                $bloqueoExistente->save();
            } else {
                BloqueoPeluquero::create([
                    'peluquero_id' => $peluqueroId,
                    'fecha' => $request->fecha,
                    'horas' => json_encode($horas),
                ]);
            }
        });

        return back()->with('success', 'Bloqueo creado con éxito.');
    }

    public function desbloquear(Request $request)
    {
        $userId = $request->user_id;

        $bloqueo = BloqueoPeluquero::where('peluquero_id', $userId)
            ->where('fecha', $request->fecha)
            ->first();

        if ($bloqueo) {
            $horasBloqueadas = json_decode($bloqueo->horas, true);

            $horasDesbloquear = $request->horas;

            $horasNoBloqueadas = array_diff($horasDesbloquear, $horasBloqueadas);

            if (!empty($horasNoBloqueadas)) {
                // Crear un nuevo array para almacenar las horas formateadas
                $horasFormateadas = [];

                foreach ($horasNoBloqueadas as $hora) {
                    // Parsear la hora con Carbon
                    $horaCarbon = Carbon::parse($hora);
                    // Formatear la hora a H:i
                    $horaFormateada = $horaCarbon->format('H:i');
                    // Añadir la hora formateada al nuevo array
                    $horasFormateadas[] = $horaFormateada;
                }

                // Devolver el error con las horas formateadas
                return back()->withErrors(['Las siguientes horas no están bloqueadas: ' . implode(', ', $horasFormateadas)]);
            }

            $horasBloqueadas = array_diff($horasBloqueadas, $horasDesbloquear);

            if (empty($horasBloqueadas)) {
                $bloqueo->delete();
            } else {
                $bloqueo->horas = json_encode(array_values($horasBloqueadas));
                $bloqueo->save();
            }

            return back()->with('success', 'Horas desbloqueadas con éxito.');
        } else {
            return back()->withErrors(['No hay horas bloqueadas para la fecha seleccionada.']);
        }
    }

    public function horasBloqueadas(Request $request)
    {
        $userId = $request->query('user_id');
        $fecha = $request->query('fecha');

        $bloqueo = BloqueoPeluquero::where('peluquero_id', $userId)
            ->where('fecha', $fecha)
            ->first();

        $horasBloqueadas = $bloqueo ? json_decode($bloqueo->horas, true) : [];

        return response()->json($horasBloqueadas);
    }
}
