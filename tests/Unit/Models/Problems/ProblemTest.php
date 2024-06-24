<?php

namespace Tests\Unit\Models\Problems;

use App\Models\Problem;
use App\Models\Teacher;
use Tests\TestCase;

class ProblemTest extends TestCase
{
    private Problem $problem;
    private Teacher $teacher;

    public function setUp(): void
    {
        parent::setUp();
        $this->teacher = new Teacher([
            'name' => 'Professor 1',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'gender' => 'Masculino',
            'birth_date' => '1999-01-02',
        ]);
        $this->teacher->save();

        $this->problem = new Problem(['title' => 'Problem 1', 'teacher_id' => $this->teacher->id]);
        $this->problem->save();
    }

    public function test_should_create_new_problem(): void
    {
        $this->assertTrue($this->problem->save());
        $this->assertCount(1, Problem::all());
    }

    public function test_all_should_return_all_problems(): void
    {
        $problems[] = $this->problem;
        $problems[] = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $problems[1]->save();

        $all = Problem::all();
        $this->assertCount(2, $all);
        $this->assertEquals($problems, $all);
    }

    public function test_destroy_should_remove_the_problem(): void
    {
        $problem2 = $this->teacher->problems()->new(['title' => 'Problem 2']);

        $problem2->save();
        $problem2->destroy();

        $this->assertCount(1, Problem::all());
    }

    public function test_set_title(): void
    {
        $problem = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $this->assertEquals('Problem 2', $problem->title);
    }

    public function test_set_id(): void
    {
        $problem = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $problem->id = 7;

        $this->assertEquals(7, $problem->id);
    }

    public function test_errors_should_return_title_error(): void
    {
        $problem = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $problem->title = '';

        $this->assertFalse($problem->isValid());
        $this->assertFalse($problem->save());
        $this->assertFalse($problem->hasErrors());

        $this->assertEquals('não pode ser vazio!', $problem->errors('title'));
    }

    public function test_find_by_id_should_return_the_problem(): void
    {
        $problem2 = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $problem1 = $this->teacher->problems()->new(['title' => 'Problem 1']);
        $problem3 = $this->teacher->problems()->new(['title' => 'Problem 3']);

        $problem1->save();
        $problem2->save();
        $problem3->save();

        $this->assertEquals($problem1, Problem::findById($problem1->id));
    }

    public function test_find_by_id_should_return_null(): void
    {
        $problem = $this->teacher->problems()->new(['title' => 'Problem 2']);
        $problem->save();

        $this->assertNull(Problem::findById(7));
    }
}
