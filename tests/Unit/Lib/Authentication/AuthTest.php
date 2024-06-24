<?php

namespace Tests\Unit\Lib\Authentication;

use Lib\Authentication\Auth;
use App\Models\Teacher;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private Teacher $teacher;

    public function setUp(): void
    {
        parent::setUp();
        $_SESSION = [];
        $this->teacher = new Teacher([
            'name' => 'Professor 1',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'gender' => 'Masculino',
            'birth_date' => '1999-01-02',
        ]);
        $this->teacher->save();
    }

    public function tearDown(): void
    {
        parent::setUp();
        $_SESSION = [];
    }

    public function test_login(): void
    {
        Auth::login($this->teacher);

        $this->assertEquals(1, $_SESSION['teacher']['id']);
    }

    public function test_teacher(): void
    {
        Auth::login($this->teacher);

        $teacherFromSession = Auth::teacher();

        $this->assertEquals($this->teacher->id, $teacherFromSession->id);
    }

    public function test_check(): void
    {
        Auth::login($this->teacher);

        $this->assertTrue(Auth::check());
    }

    public function test_logout(): void
    {
        Auth::login($this->teacher);
        Auth::logout();

        $this->assertFalse(Auth::check());
    }
}
