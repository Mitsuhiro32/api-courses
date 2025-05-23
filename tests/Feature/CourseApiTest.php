<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseApiTest extends TestCase
{
    /**
     * Prueba la obtención de la lista de cursos a través de la API.
     */
    public function test_can_list_courses()
    {
        // Autentica a un usuario.
        $this->authUser();

        Course::create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        // Envía una solicitud GET al endpoint '/api/courses'.
        $response = $this->get('/api/courses');

        // Verifica que el estado de la respuesta sea 200 (OK).
        $response->assertStatus(200);
    }

    /**
     * Prueba la creación de un curso a través de la API.
     */
    public function test_can_create_course()
    {
        $this->authUser();

        $response = $this->post('/api/courses', [
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Prueba la obtención de un curso a través de la API.
     */
    public function test_can_show_course()
    {
        $this->authUser();

        $course = Course::create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response = $this->get('/api/courses/' . $course->id);

        $response->assertStatus(200);
    }

    /**
     * Prueba la actualización de un curso a través de la API.
     */
    public function test_can_update_course()
    {
        $this->authUser();

        $course = Course::create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response = $this->put('/api/courses/' . $course->id, [
            'title' => 'Updated Course',
            'description' => 'Updated Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response->assertStatus(200);
    }

    /**
     * Prueba la eliminación de un curso a través de la API.
     */
    public function test_can_delete_course()
    {
        $this->authUser();

        $course = Course::create([
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ]);

        $response = $this->delete('/api/courses/' . $course->id);

        $response->assertStatus(200);
    }
}
