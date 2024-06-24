<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property int $problem_id
 * @property int $teacher_id
 */
class ProblemTeacherReinforce extends Model
{
    protected static string $table = 'problem_teacher_reinforce';
    protected static array $columns = ['problem_id', 'teacher_id'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function problem(): BelongsTo
    {
        return $this->belongsTo(Problem::class, 'problem_id');
    }

    public function validates(): void
    {
        Validations::uniqueness(['problem_id', 'teacher_id'], $this);
    }
}
