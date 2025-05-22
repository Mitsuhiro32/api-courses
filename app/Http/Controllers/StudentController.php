<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los estudiantes
        $students = Student::all();

        // Verificar si hay estudiantes registrados
        if(!$students->isNotEmpty()){
            return response()->json('No hay estudiantes registrados', 404);
        } else {
            return response()->json($students);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Verificar si el estudiante existe
        $student = Student::find($id);
        if (!$student) {
            return response()->json('Estudiante no encontrado', 404);
        }

        // Retornar los datos del estudiante
        return response()->json($student);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:students',
            'birthdate' => 'required|date',
            'nationality' => 'required|string',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'La fecha de nacimiento no es válida.',
            'nationality.required' => 'La nacionalidad es obligatoria.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }

        // Crear un nuevo estudiante
        $student = Student::create($validatedData->validated());

        return response()->json($student, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        // Verificar si el estudiante existe
        if (!$student) {
            return response()->json('Estudiante no encontrado', 404);
        }

        // Validar los datos de entrada
        $validatedData = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:students,email,' . $student->id,
            'birthdate' => 'sometimes|required|date',
            'nationality' => 'sometimes|required|string',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'La fecha de nacimiento no es válida.',
            'nationality.required' => 'La nacionalidad es obligatoria.',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'errors' => $validatedData->errors()
            ], 422);
        }

        // Actualizar el estudiante
        $student->update($validatedData->validated());

        return response()->json($student, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        // Verificar si el estudiante existe
        if (!$student) {
            return response()->json('Estudiante no encontrado', 404);
        }
        // Eliminar el estudiante
        $student->delete();

        return response()->json('Estudiante eliminado correctamente', 200);
    }
}
