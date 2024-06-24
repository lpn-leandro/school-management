<?php

namespace Tests\Unit\Models;

use App\Models\Problem;
use App\Models\ProblemTeacherReinforce;
use App\Models\Teacher;
use Tests\TestCase;

class ProblemTeacherReinforceTest extends TestCase
{
    private Teacher $teacher;
    private Problem $problem;

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

    public function test_save_problem_teacher_reinforce(): void
    {
        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $this->problem->id,
            'teacher_id' => $this->teacher->id
        ]);

        $this->assertTrue($problemTeacherReforce->save());
        $this->assertCount(1, ProblemTeacherReinforce::all());
    }

    public function test_save_problem_teacher_reinforce_with_invalid_data(): void
    {
        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $this->problem->id,
            'teacher_id' => $this->teacher->id
        ]);

        $problemTeacherReforce->save();

        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $this->problem->id,
            'teacher_id' => $this->teacher->id
        ]);

        $this->assertFalse($problemTeacherReforce->save());
        $this->assertCount(1, ProblemTeacherReinforce::all());
    }
}
