<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnrollmentApiTest extends TestCase
{
    /**
     * Prueba la obtención de la lista de inscripciones a través de la API.
     */
    public function test_can_list_enrollments()
    {
        // Autentica a un usuario.
        $this->authUser();

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

        Enrollment::create([
            'student_id' => 1,
            'course_id' => 1,
        ]);

        // Envía una solicitud GET al endpoint '/api/enrollments'.
        $response = $this->get('/api/enrollments');
        $response2 = $this->get('/api/enrollments?student_id=1');
        $response3 = $this->get('/api/enrollments?course_id=1');

        // Verifica que el estado de la respuesta sea 200 (OK).
        $response->assertStatus(200);
        $response2->assertStatus(200);
        $response3->assertStatus(200);
    }

    /**
     * Prueba la creación de una inscripción a través de la API.
     */
    public function test_can_create_enrollment()
    {
        $this->authUser();

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

        $response = $this->post('/api/enrollments', [
            'student_id' => 1,
            'course_id' => 1,
        ]);

        $response->assertStatus(201);
    }

    /**
     * Prueba la actualización de una inscripción a través de la API.
     */
    public function test_can_delete_enrollment()
    {
        $this->authUser();

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

        $enrollment = Enrollment::create([
            'student_id' => 1,
            'course_id' => 1,
        ]);

        $response = $this->delete('/api/enrollments/' . $enrollment->id);

        $response->assertStatus(200);
    }
}
