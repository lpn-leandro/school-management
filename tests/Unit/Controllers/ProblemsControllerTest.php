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
            'password_confirmation' => '123456',
            'gender' => 'Masculino',
            'birth_date' => '1999-01-02',

        ]);
        $teacher->save();
        $_SESSION['teacher']['id'] = $teacher->id;

        $response = $this->get(action: 'index', controller: 'App\Controllers\ProblemsController');

        $this->assertStringContainsString('Home', $response);
    }
}
