<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    public function index(Request $req)
    {
        return Topic::all();
    }

    public function show($topic)
    {
        $result = Topic::find($topic);
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'topic_title' => 'required|string|max:255',
            'topic_description' => 'required|string|max:255',
            'topic_date' => 'required|date',
            'user_id' => 'required|numeric|exists:users,id',
            'congress_id' => 'required|numeric|exists:congresos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = new Topic;

        $datos->fill($req->all());

        $result = $datos->save();

        if ($result) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function update(Request $req, $topic)
    {
        $validator = Validator::make($req->all(), [
            'topic_title' => 'filled|string|max:255',
            'topic_description' => 'filled|string|max:255',
            'topic_date' => 'filled|date',
            'user_id' => 'filled|numeric|exists:users,id',
            'congress_id' => 'filled|numeric|exists:congresos,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $datos = Topic::find($topic);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Topic not found'], 404);
        }

        $result = $datos->fill($req->all())->save();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Topic updated successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to update Topic'], 500);
        }
    }

    public function destroy($topic)
    {
        $datos = Topic::find($topic);

        if (!$datos) {
            return response()->json(['status' => 'failed', 'message' => 'Topic not found'], 404);
        }

        $result = $datos->delete();

        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Topic deleted successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Failed to delete Topic'], 500);
        }
    }
}
