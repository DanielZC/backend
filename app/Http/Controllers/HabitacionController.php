<?php

namespace App\Http\Controllers;

use App\Models\HabitacionModel;
use App\Rules\AcomodacionRule;
use App\Rules\CantidadRule;
use App\Rules\TipoHabitacionAcomodacionRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $habitaciones = HabitacionModel::all();
            return response()->json(['data' => $habitaciones], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    public function listByHotelId(String $id)
    {
        try {
            $habitaciones = HabitacionModel::where('hotel_id', "=", $id, false)->get();
            return response()->json(['data' => $habitaciones], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'hotel_id' => ['required', 'numeric', 'exists:hoteles,id'],
                'cantidad' => ['required', 'numeric', new CantidadRule],
                'tipo_habitacion' => ['required', Rule::in(['Junior', 'Estándar', 'Suite'])],
                'acomodacion' => ['required', Rule::in(['Sencilla', 'Doble', 'Triple', 'Cuádruple']), new AcomodacionRule, new TipoHabitacionAcomodacionRule]
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $habitacion = new HabitacionModel($validator->validate());
            $habitacion->save();

            return response()->json(['data' => $habitacion], 201);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $habitacion = HabitacionModel::find($id, [
                'hotel_id',
                'cantidad',
                'tipo_habitacion',
                'acomodacion',
            ]);

            if (!$habitacion) {
                return response()->json(['msg' => 'habitacion no encontrado'], 404);
            }

            return response()->json(['data' => $habitacion], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (empty($request->all())) {
                return response()->json(['msg' => 'La petición de tener como minimo un dato para actualizar'], 400);
            }

            $validator = Validator::make($request->all(), [
                'hotel_id' => ['required', 'numeric', 'exists:hoteles,id'],
                'cantidad' => ['numeric', new CantidadRule],
                'tipo_habitacion' => [Rule::in(['Junior', 'Estándar', 'Suite'])],
                'acomodacion' => [Rule::in(['Sencilla', 'Doble', 'Triple', 'Cuádruple']), new AcomodacionRule, new TipoHabitacionAcomodacionRule($id)]
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $habitacion = HabitacionModel::find($id, ['*']);

            $habitacion->update($validator->validate());

            return response()->json(['data' => $habitacion], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $habitacion = HabitacionModel::find($id, ['*']);

            if (!$habitacion) {
                return response()->json(['msg' => 'habitacion no encontrado'], 404);
            }

            $habitacion->delete();
            return response()->json(['data' => 'deleted'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }
}
