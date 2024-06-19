<?php

namespace App\Controllers;

use Core\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show(): void
    {
        $title = 'Meu Perfil';
        $this->render('profile/show', compact('title'));
    }

    public function updateAvatar(): void
    {
        $image = $_FILES['teacher_avatar'];

        $this->current_teacher->avatar()->update($image);
        $this->redirectTo(route('profile.show'));
    }
}
