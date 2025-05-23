<?php

namespace Tests\Unit;

use App\Models\Student;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Prueba la creación de un estudiante.
     */
    public function test_can_create_student()
    {
        // Crea un estudiante con datos de prueba.
        $student = [
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ];

        $student = Student::create($student);

        // Verifica que el estudiante tenga los datos correctos.
        $this->assertEquals('Test Student', $student->name);
        $this->assertEquals('test@student.com', $student->email);
        $this->assertEquals('2000-01-01', $student->birthdate);
        $this->assertEquals('Test Nationality', $student->nationality);
    }
}
