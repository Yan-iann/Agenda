<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;

class AgendaController extends Controller
{
    public function getAgenda()
    {
        return response()->json(Agenda::get());
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

    public function updateAgenda(Request $request, $id)
    {
        Agenda::where('id', $id)->update([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'author' => $request->author,
        ]);

        return response()->json('Agenda Successfully Updated');
    }
    public function removeAgenda($id){
        Agenda::where('id', $id)->delete();
        return response()->json('Agenda Successfully Deleted');
    }
}
