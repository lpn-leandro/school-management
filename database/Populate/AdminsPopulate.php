<?php

namespace Database\Populate;

use App\Models\Admin;

class AdminsPopulate
{
    public static function populate()
    {
        $data =  [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
            'gender' => 'Masculino',
            'birth_date' => '1999-01-02', // YYYY-MM-DD
        ];

        $teacher = new Admin($data);
        $teacher->save();

        $numberOfAdmins = 10;

        for ($i = 1; $i < $numberOfAdmins; $i++) {
            $data =  [
                'name' => 'Admin ' . $i,
                'email' => 'admin' . $i . '@example.com',
                'password' => '123456',
                'password_confirmation' => '123456',
                'gender' => 'Masculino',
                'birth_date' => '1999-01-02', // DD/MM/YYYY
            ];

            $teacher = new Admin($data);
            $teacher->save();
        }

        echo "Admins populated with $numberOfAdmins registers\n";
    }
}
