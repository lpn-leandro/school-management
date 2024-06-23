<?php

namespace Tests\Unit\Models\Problems;

use App\Models\Problem;
use App\Models\ProblemTeacherReinforce;
use App\Models\Teacher;
use Tests\TestCase;

class ProblemReinforcedByTeachersTest extends TestCase
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
            'password_confirmation' => '123456'
        ]);
        $this->teacher->save();

        $this->problem = new Problem(['title' => 'Problem 1', 'teacher_id' => $this->teacher->id]);
        $this->problem->save();
    }

    public function test_count_reinforced_teachers(): void
    {
        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $this->problem->id,
            'teacher_id' => $this->teacher->id
        ]);
        $problemTeacherReforce->save();

        $this->assertEquals(1, $this->problem->reinforcedByTeachers()->count());
    }

    public function test_get_all_reinforced_teachers(): void
    {
        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $this->problem->id,
            'teacher_id' => $this->teacher->id
        ]);
        $problemTeacherReforce->save();

        $teacher = new Teacher([
            'name' => 'Professor 2',
            'email' => 'professor2@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $teacher->save();

        $otherProblem = new Problem(['title' => 'Problem 1', 'teacher_id' => $teacher->id]);
        $otherProblem->save();

        $problemTeacherReforceByOtherTeacher = new ProblemTeacherReinforce([
            'problem_id' => $otherProblem->id,
            'teacher_id' => $teacher->id
        ]);
        $problemTeacherReforceByOtherTeacher->save();

        $this->assertCount(2, ProblemTeacherReinforce::all());
        $this->assertEquals(1, $this->problem->reinforcedByTeachers()->count());

        $this->assertEquals($this->teacher->id, $this->problem->reinforced_by_teachers[0]->id);
        $this->assertNotEquals($teacher->id, $this->problem->reinforced_by_teachers[0]->id);
    }
}
