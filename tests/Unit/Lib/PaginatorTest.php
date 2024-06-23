<?php

namespace Tests\Unit\Lib;

use App\Models\Problem;
use App\Models\Teacher;
use Lib\Paginator;
use Tests\TestCase;

class PaginatorTest extends TestCase
{
    private Paginator $paginator;
    /** @var mixed[] $problems */
    private array $problems;

    public function setUp(): void
    {
        parent::setUp();
        $teacher = new Teacher([
            'name' => 'Professor 1',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);
        $teacher->save();

        for ($i = 0; $i < 10; $i++) {
            $problem = new Problem(['title' => "Problem $i", 'teacher_id' => $teacher->id]);
            $problem->save();
            $this->problems[] = $problem;
        }
        $this->paginator = new Paginator(Problem::class, 1, 5, 'problems', ['title']);
    }

    public function test_total_of_registers(): void
    {
        $this->assertEquals(10, $this->paginator->totalOfRegisters());
    }

    public function test_total_of_pages(): void
    {
        $this->assertEquals(2, $this->paginator->totalOfPages());
    }

    public function test_total_of_pages_when_the_division_is_not_exact(): void
    {
        $problem = new Problem(['title' => 'Problem 11', 'teacher_id' => $this->problems[0]->teacher_id]);
        $problem->save();
        $this->paginator = new Paginator(Problem::class, 1, 5, 'problems', ['title']);

        $this->assertEquals(3, $this->paginator->totalOfPages());
    }

    public function test_previous_page(): void
    {
        $this->assertEquals(0, $this->paginator->previousPage());
    }

    public function test_next_page(): void
    {
        $this->assertEquals(2, $this->paginator->nextPage());
    }

    public function test_has_previous_page(): void
    {
        $this->assertFalse($this->paginator->hasPreviousPage());

        $paginator = new Paginator(Problem::class, 2, 5, 'problems', ['title']);
        $this->assertTrue($paginator->hasPreviousPage());
    }

    public function test_has_next_page(): void
    {
        $this->assertTrue($this->paginator->hasNextPage());

        $paginator = new Paginator(Problem::class, 2, 5, 'problems', ['title']);
        $this->assertFalse($paginator->hasNextPage());
    }

    public function test_is_page(): void
    {
        $this->assertTrue($this->paginator->isPage(1));
        $this->assertFalse($this->paginator->isPage(2));
    }

    public function test_entries_info(): void
    {
        $entriesInfo = 'Mostrando 1 - 5 de 10';
        $this->assertEquals($entriesInfo, $this->paginator->entriesInfo());
    }

    public function test_register_return_all(): void
    {
        $this->assertCount(5, $this->paginator->registers());

        $paginator = new Paginator(Problem::class, 1, 10, 'problems', ['title', 'teacher_id']);
        $this->assertEquals($this->problems, $paginator->registers());
    }
}
