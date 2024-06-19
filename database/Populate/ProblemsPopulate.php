<?php

namespace Database\Populate;

use App\Models\Problem;
use App\Models\Teacher;

class ProblemsPopulate
{
    public static function populate()
    {
        $teacher = Teacher::findBy(['email' => 'professor@example.com']);

        $numberOfProblems = 100;

        for ($i = 0; $i < $numberOfProblems; $i++) {
            $problem = new Problem(['title' => 'Problem ' . $i, 'teacher_id' => $teacher->id]);
            $problem->save();
        }

        echo "Problems populated with $numberOfProblems registers\n";
    }
}
