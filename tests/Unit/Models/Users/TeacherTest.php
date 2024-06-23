<?php

namespace tests\Unit\Models\Teachers;

use App\Models\Teacher;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    private Teacher $teacher;
    private Teacher $teacher2;

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

        $this->teacher2 = new Teacher([
            'name' => 'Professor 2',
            'email' => 'professor1@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $this->teacher2->save();
    }

    public function test_should_create_new_teacher(): void
    {
        $this->assertCount(2, Teacher::all());
    }

    public function test_all_should_return_all_teachers(): void
    {
        $this->teacher2->save();

        $teachers[] = $this->teacher->id;
        $teachers[] = $this->teacher2->id;

        $all = array_map(fn ($teacher) => $teacher->id, Teacher::all());

        $this->assertCount(2, $all);
        $this->assertEquals($teachers, $all);
    }

    public function test_destroy_should_remove_the_teacher(): void
    {
        $this->teacher->destroy();
        $this->assertCount(1, Teacher::all());
    }

    public function test_set_id(): void
    {
        $this->teacher->id = 10;
        $this->assertEquals(10, $this->teacher->id);
    }

    public function test_set_name(): void
    {
        $this->teacher->name = 'Teacher name';
        $this->assertEquals('Teacher name', $this->teacher->name);
    }

    public function test_set_email(): void
    {
        $this->teacher->email = 'outro@example.com';
        $this->assertEquals('outro@example.com', $this->teacher->email);
    }

    public function test_errors_should_return_errors(): void
    {
        $teacher = new Teacher();

        $this->assertFalse($teacher->isValid());
        $this->assertFalse($teacher->save());
        $this->assertFalse($teacher->hasErrors());

        $this->assertEquals('não pode ser vazio!', $teacher->errors('name'));
        $this->assertEquals('não pode ser vazio!', $teacher->errors('email'));
    }

    public function test_errors_should_return_password_confirmation_error(): void
    {
        $teacher = new Teacher([
            'name' => 'Professor 3',
            'email' => 'professor3@example.com',
            'password' => '123456',
            'password_confirmation' => '1234567'
        ]);

        $this->assertFalse($teacher->isValid());
        $this->assertFalse($teacher->save());

        $this->assertEquals('as senhas devem ser idênticas!', $teacher->errors('password'));
    }

    public function test_find_by_id_should_return_the_teacher(): void
    {
        $this->assertEquals($this->teacher->id, Teacher::findById($this->teacher->id)->id);
    }

    public function test_find_by_id_should_return_null(): void
    {
        $this->assertNull(Teacher::findById(3));
    }

    public function test_find_by_email_should_return_the_teacher(): void
    {
        $this->assertEquals($this->teacher->id, Teacher::findByEmail($this->teacher->email)->id);
    }

    public function test_find_by_email_should_return_null(): void
    {
        $this->assertNull(Teacher::findByEmail('not.exits@example.com'));
    }

    public function test_authenticate_should_return_the_true(): void
    {
        $this->assertTrue($this->teacher->authenticate('123456'));
        $this->assertFalse($this->teacher->authenticate('wrong'));
    }

    public function test_authenticate_should_return_false(): void
    {
        $this->assertFalse($this->teacher->authenticate(''));
    }

    public function test_update_should_not_change_the_password(): void
    {
        $this->teacher->password = '654321';
        $this->teacher->save();

        $this->assertTrue($this->teacher->authenticate('123456'));
        $this->assertFalse($this->teacher->authenticate('654321'));
    }
}
