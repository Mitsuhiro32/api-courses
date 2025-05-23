<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    /**
     * Prueba la obtención de la lista de estudiantes a través de la API.
     *
     * @test
     */
    public function can_list_students()
    {
        // Autentica a un usuario.
        $this->authUser();

        // Crea un estudiante con datos de prueba.
        Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        // Envía una solicitud GET al endpoint '/api/students'.
        $response = $this->get('/api/students');

        // Verifica que el estado de la respuesta sea 200 (OK).
        $response->assertStatus(200);
    }

    /**
     * Prueba la creación de un estudiante a través de la API.
     *
     * @test
     */
    public function can_create_student()
    {
        $this->authUser();

        $response = $this->post('/api/students', [
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Prueba la obtención de un estudiante a través de la API.
     *
     * @test
     */
    public function can_show_student()
    {
        $this->authUser();

        $student = Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        $response = $this->get('/api/students/' . $student->id);

        $response->assertStatus(200);
    }

    /**
     * Prueba la actualización de un estudiante a través de la API.
     *
     * @test
     */
    public function can_update_student()
    {
        $this->authUser();

        $student = Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        $response = $this->put('/api/students/' . $student->id, [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Prueba la eliminación de un estudiante a través de la API.
     *
     * @test
     */
    public function can_delete_student()
    {
        $this->authUser();

        $student = Student::create([
            'name' => 'Test Student',
            'email' => 'test@student.com',
            'birthdate' => '2000-01-01',
            'nationality' => 'Test Nationality',
        ]);

        $response = $this->delete('/api/students/' . $student->id);

        $response->assertStatus(200);
    }
}
