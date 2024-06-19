<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\BelongsToMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $title
 * @property int $teacher_id
 * @property Teacher $teacher
 * @property Teacher[] $reinforced_by_teachers
 */
class Problem extends Model
{
    protected static string $table = 'problems';
    protected static array $columns = ['title', 'teacher_id'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function reinforcedByTeachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'problem_teacher_reinforce', 'problem_id', 'teacher_id');
    }

    public function validates(): void
    {
        Validations::notEmpty('title', $this);
    }

    public function isSupportedByTeacher(Teacher $teacher): bool
    {
        return ProblemTeacherReinforce::exists(['problem_id' => $this->id, 'teacher_id' => $teacher->id]);
    }
}
