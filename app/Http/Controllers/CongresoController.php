<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Congreso;
use Illuminate\Support\Facades\Validator;

class CongresoController extends Controller
{
    public function index()
    {
        return Congreso::all();
    }

    public function show($congreso)
    {
        $result = Congreso::find($congreso);
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'congress_title' => 'required|string|max:255',
            'congress_description' => 'required|string|max:255',
            'congress_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = new Congreso;
        $datos->fill($req->all());
        $result = $datos->save();

        if ($result) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function update(Request $req, $congreso)
    {
        $validator = Validator::make($req->all(), [
            'congress_title' => 'filled|string|max:255',
            'congress_description' => 'nullable|string|max:255',
            'congress_date' => 'filled|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = Congreso::find($congreso);
        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Congreso no encontrado'], 404);
        }

        $result = $datos->fill($req->all())->save();
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Congreso actualizado correctamente'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'No se pudo actualizar el Congreso'], 500);
        }
    }

    public function destroy($congreso)
    {
        $datos = Congreso::find($congreso);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Congreso no encontrado'], 404);
        }

        $result = $datos->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Congreso eliminado correctamente'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'No se pudo eliminar el Congreso'], 500);
        }
    }
}
