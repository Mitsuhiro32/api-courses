<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los cursos
        $courses = Course::all();

        // Verificar si hay cursos registrados
        if (!$courses->isNotEmpty()) {
            return response()->json('No hay cursos registrados', 404);
        } else {
            return response()->json($courses);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);

        // Verificar si el curso existe
        if (!$course) {
            return response()->json('Curso no encontrado', 404);
        }
        return response()->json($course);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ],[
            'title.required' => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }

        // Crear un nuevo curso
        $course = Course::create($validatedData->validated());

        return response()->json($course, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Buscar el curso por ID
        $course = Course::find($id);

        // Verificar si el curso existe
        if (!$course) {
            return response()->json('Curso no encontrado', 404);
        }

        // Validar los datos de entrada
        $validatedData = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }

        // Actualizar el curso
        $course->update($validatedData->validated());

        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        // Verificar si el curso existe
        if (!$course) {
            return response()->json('Curso no encontrado', 404);
        }

        // Eliminar el curso
        $course->delete();

        return response()->json('Curso eliminado correctamente', 200);
    }
}
