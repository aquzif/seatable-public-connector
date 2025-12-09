<?php

namespace App\Http\Controllers;


use App\Models\Request;

class APIController extends Controller
{
    public function getRequestsToImport() {
        $requests = \App\Models\Request::where('status', 'ready')->get();
        return response()->json($requests);
    }

    public function markRequestAsImported(Request $request) {
        $request->status = 'imported';
        $request->save();
        return response()->json(['message' => 'Request marked as imported']);
    }
}
