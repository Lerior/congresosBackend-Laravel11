<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class AttendanceController extends Controller
{
    public function index(Request $req)
    {
        return Attendance::all();
    }

    public function show($attendance)
    {
        $result = Attendance::find($attendance);
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'attendance_user_id' => 'required|numeric|exists:users,id',
            'attendance_topic_id' => 'required|numeric|exists:topics,id'
        ]);

        $datos = new Attendance;

        $datos->fill($req->all());

        $result = $datos->save();

        if ($result) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function update(Request $req, $attendance)
    {
        $validator = Validator::make($req->all(), [
            'attendance_user_id' => 'filled|numeric|exists:users,id',
            'attendance_topic_id' => 'filled|numeric|exists:topics,id'
        ]);

        $datos = Attendance::find($attendance);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Attendance not found'], 404);
        }

        $result = $datos->fill($req->all())->save();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to update Attendance'], 500);
        }
    }

    public function destroy($attendance)
    {
        $datos = Attendance::find($attendance);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Attendance not found'], 404);
        }

        $result = $datos->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Attendance deleted successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete Attendance'], 500);
        }
    }
}
