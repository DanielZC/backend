<?php

namespace App\Http\Controllers;

use App\Models\HotelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hoteles = HotelModel::all();
            return response()->json(['data' => $hoteles], 200);
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
                'ciudad' => ['required', 'string', 'min:4', 'max:40'],
                'nombre' => ['required', Rule::unique('hoteles'), 'string', 'min:4', 'max:64'],
                'nit' => ['required', Rule::unique('hoteles'), 'string', 'min:4', 'max:40'],
                'direccion' => ['required', Rule::unique('hoteles'), 'string', 'min:4', 'max:200'],
                'numero_habitaciones' => ['required', 'numeric']
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $hotel = new HotelModel($validator->validate());
            $hotel->save();

            return response()->json(['data' => $hotel], 201);
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
            $hotel = HotelModel::find($id, [
                'ciudad',
                'nombre',
                'nit',
                'direccion',
                'numero_habitaciones'
            ]);

            if (!$hotel) {
                return response()->json(['msg' => 'Hotel no encontrado'], 404);
            }

            $habitaciones = DB::table('habitaciones')->where('hotel_id', $id)->get();

            return response()->json(['data' => $hotel, 'habitaciones' => $habitaciones], 200);
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
                'ciudad' => ['string', 'min:4', 'max:40'],
                'nombre' => ['string', Rule::unique('hoteles')->ignore($id), 'min:4', 'max:64'],
                'nit' => ['string', Rule::unique('hoteles')->ignore($id), 'min:4', 'max:40'],
                'direccion' => ['string', Rule::unique('hoteles')->ignore($id), 'min:4', 'max:200'],
                'numero_habitaciones' => ['numeric']
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $hotel = HotelModel::find($id, ['*']);

            $hotel->update($validator->validate());

            return response()->json(['data' => $hotel], 200);
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
            $hotel = HotelModel::find($id, ['*']);

            if (!$hotel) {
                return response()->json(['msg' => 'Hotel no encontrado'], 404);
            }

            $hotel->delete();
            return response()->json(['data' => 'deleted'], 200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage()], 500);
        }
    }
}
