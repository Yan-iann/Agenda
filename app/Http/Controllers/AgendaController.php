<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function getAgenda()
    {
        return response()->json(Agenda::latest()->get());
    }
    
    public function storeAgenda(Request $request)
    {
        Agenda::create([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'author' => $request->author,
        ]);

        return response()->json('Agenda Successfully Created');
    }
}
