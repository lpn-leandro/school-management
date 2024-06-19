<?php

namespace Lib\Authentication;

use App\Models\Teacher;

class Auth
{
    public static function login($teacher): void
    {
        $_SESSION['teacher']['id'] = $teacher->id;
    }

    public static function teacher(): ?Teacher
    {
        if (isset($_SESSION['teacher']['id'])) {
            $id = $_SESSION['teacher']['id'];
            return Teacher::findById($id);
        }

        return null;
    }

    public static function check(): bool
    {
        return isset($_SESSION['teacher']['id']) && self::teacher() !== null;
    }

    public static function logout(): void
    {
        unset($_SESSION['teacher']['id']);
    }
}
