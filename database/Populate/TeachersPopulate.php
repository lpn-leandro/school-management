<?php

namespace Database\Populate;

use App\Models\Teacher;

class TeachersPopulate
{
    public static function populate()
    {
        $data =  [
            'name' => 'Professor',
            'email' => 'professor@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'gender' => 'Masculino',
            'birth_date' => '1999-01-02', // YYYY-MM-DD
        ];

        $teacher = new Teacher($data);
        $teacher->save();

        $numberOfTeachers = 10;

        for ($i = 1; $i < $numberOfTeachers; $i++) {
            $data =  [
                'name' => 'Professor ' . $i,
                'email' => 'professor' . $i . '@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'gender' => 'Masculino',
                'birth_date' => '1999-01-02', // DD/MM/YYYY
            ];

            $teacher = new Teacher($data);
            $teacher->save();
        }

        echo "Teachers populated with $numberOfTeachers registers\n";
    }
}
