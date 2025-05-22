<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validar los parámetros de búsqueda
        $validatedData = Validator::make($request->all(), [
            'student_id' => 'sometimes|exists:students,id',
            'course_id' => 'sometimes|exists:courses,id',
        ], [
            'student_id.exists' => 'El estudiante no existe.',
            'course_id.exists' => 'El curso no existe.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }
        // Verificar si hay parámetros de búsqueda
        if ($request->has('student_id') || $request->has('course_id')) {
            if ($request->has('student_id')) {
                $enrollments = Enrollment::where('student_id', $request->student_id)
                    ->with(['student', 'course'])
                    ->get();
            } else {
                $enrollments = Enrollment::where('course_id', $request->course_id)
                    ->with(['student', 'course'])
                    ->get();
            }

            // Verificar si hay inscripciones registradas
            if (!$enrollments->isNotEmpty()) {
                return response()->json('No hay inscripciones registradas', 404);
            } else {
                return response()->json($enrollments);
            }
        } else {
            // Obtener todas las inscripciones
            $enrollments = Enrollment::with(['student', 'course'])->get();
            // Verificar si hay inscripciones registradas
            if (!$enrollments->isNotEmpty()) {
                return response()->json('No hay inscripciones registradas', 404);
            } else {
                return response()->json($enrollments);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
        ], [
            'student_id.required' => 'El ID del estudiante es obligatorio.',
            'student_id.exists' => 'El estudiante no existe.',
            'course_id.required' => 'El ID del curso es obligatorio.',
            'course_id.exists' => 'El curso no existe.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }

        // Crear una nueva inscripción
        $enrollment = Enrollment::create($validatedData->validated());

        return response()->json($enrollment, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Verificar si la inscripción existe
        $enrollment = Enrollment::find($id);
        if (!$enrollment) {
            return response()->json('Inscripción no encontrada', 404);
        }

        // Eliminar la inscripción
        $enrollment->delete();

        return response()->json('Inscripción eliminada con éxito', 200);
    }
}
