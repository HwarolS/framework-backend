<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Label;
use App\Models\Label_Content_Relationship;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::all();

        return response()->json($contents, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'labels' => 'array',
        ]);

        $content = Content::create(
            [
                'title' => $request->title,
                'content' => $request->content,
                'created_by_id' => auth()->user()->user_id,
            ]
        );

        if ($request->has('labels')) {
            $request->validate([
                'labels.*.id' => 'required|exists:labels,id',
            ]);
            foreach ($request->labels as $label) {
                $content->labels()->attach($label['id']);
            }
        }

        $content->load('labels');

        return response()->json([
            'message' => 'Contenido Creado Correctamente',
            'content' => $content,
        ], 201);
    }

    public function show ($id)
    {
        $content = Content::find($id);

        if (is_null($content)) {
            return response()->json([
                'message' => 'Contenido no encontrado',
            ], 404);
        }

        $content->load('labels');

        return response()->json([
            'content' => $content,
        ], 200);
    }

    public function update (Request $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'El id debe ser un número',
            ], 400);
        }

        $content = Content::find($id);

        if (is_null($content)) {
            return response()->json([
                'message' => 'Contenido no encontrado',
            ], 404);
        }elseif (auth()->user()->role_id !== 1 && ($content->created_by_id !== auth()->user()->user_id)) {
            return response()->json([
                'message' => 'No se encontró el contenido',
            ], 404);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'labels' => 'array',
        ]);

        $content->update($request->all());
        if ($request->has('labels')) {
            $request->validate([
                'labels.*.id' => 'required|exists:labels,id',
            ]);
            $content->labels()->detach();
            foreach ($request->labels as $label) {
                $content->labels()->attach($label['id']);
            }
        }

        $content->load('labels');

        return response()->json([
            'message' => 'Contenido Actualizado Correctamente',
            'content' => $content,
        ], 200);
    }

    public function destroy ($id)
    {
        $content = Content::find($id);

        if (is_null($content)) {
            return response()->json([
                'message' => 'Contenido no encontrado',
            ], 404);
        }elseif (auth()->user()->role_id !== 1 && ($content->created_by_id !== auth()->user()->user_id)) {
            return response()->json([
                'message' => 'No se encontró el contenido',
            ], 404);
        }

        $content->labels()->detach();
        $content->delete();

        return response()->json([
            'message' => 'Contenido Eliminado Correctamente',
        ], 200);
    }
}