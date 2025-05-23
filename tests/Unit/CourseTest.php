<?php

namespace Tests\Unit;

use App\Models\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Prueba la creación de un curso.
     *
     */
    public function test_can_create_course()
    {
        // Crea un curso con datos de prueba.
        $course = [
            'title' => 'Test Course',
            'description' => 'Test Description',
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ];

        $course = Course::create($course);

        // Verifica que el curso tenga los datos correctos.
        $this->assertEquals('Test Course', $course->title);
        $this->assertEquals('Test Description', $course->description);
        $this->assertEquals('2023-01-01', $course->start_date);
        $this->assertEquals('2023-12-31', $course->end_date);
    }
}
