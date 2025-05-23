<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Prueba la creación de una inscripción.
     */
    public function test_can_create_enrollment()
    {
        Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        Course::create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        // Crea una inscripción con datos de prueba.
        $enrollment = [
            'student_id' => 1,
            'course_id' => 1,
        ];

        $enrollment = Enrollment::create($enrollment);

        // Verifica que la inscripción tenga los datos correctos.
        $this->assertEquals(1, $enrollment->student_id);
        $this->assertEquals(1, $enrollment->course_id);
    }
}
