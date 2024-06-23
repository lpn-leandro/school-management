<?php

namespace Tests\Unit\Controllers;

use App\Models\Problem;
use App\Models\Teacher;

class ProblemsControllerTest extends ControllerTestCase
{
    public function test_list_all_problems(): void
    {
        $teacher = new Teacher([
            'name' => 'Professor 1',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $teacher->save();
        $_SESSION['teacher']['id'] = $teacher->id;

        $problems[] = new Problem(['title' => 'Problem 1', 'teacher_id' => $teacher->id]);
        $problems[] = new Problem(['title' => 'Problem 2',  'teacher_id' => $teacher->id]);

        foreach ($problems as $problem) {
            $problem->save();
        }

        $response = $this->get(action: 'index', controller: 'App\Controllers\ProblemsController');

        foreach ($problems as $problem) {
            $this->assertMatchesRegularExpression("/{$problem->title}/", $response);
        }
    }
}
