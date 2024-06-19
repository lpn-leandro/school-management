<?php

namespace Tests\Unit\Models\Problems;

use App\Models\Problem;
use App\Models\ProblemTeacherReinforce;
use App\Models\Teacher;
use Tests\TestCase;

class ProblemIsSupportedByTeacherTest extends TestCase
{
    public function test_is_supported_by_teacher(): void
    {
        $teacher = new Teacher([
            'name' => 'Professor 1',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $teacher->save();

        $problem = new Problem(['title' => 'Problem 1', 'teacher_id' => $teacher->id]);
        $problem->save();

        $problemTwo = new Problem(['title' => 'Problem 1', 'teacher_id' => $teacher->id]);
        $problemTwo->save();

        $problemTeacherReforce = new ProblemTeacherReinforce([
            'problem_id' => $problem->id,
            'teacher_id' => $teacher->id
        ]);
        $problemTeacherReforce->save();

        $this->assertTrue($problem->isSupportedByTeacher($teacher));
        $this->assertFalse($problemTwo->isSupportedByTeacher($teacher));
    }
}
