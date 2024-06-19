<?php

namespace App\Controllers;

use App\Models\Teacher;
use Core\Http\Controllers\Controller;
use Core\Http\Request;
use Lib\Authentication\Auth;
use Lib\FlashMessage;

class AuthenticationsController extends Controller
{
    protected string $layout = 'login';

    public function new(): void
    {
        $this->render('authentications/new');
    }

    public function authenticate(Request $request): void
    {
        $params = $request->getParam('teacher');
        $teacher = Teacher::findByEmail($params['email']);

        if ($teacher && $teacher->authenticate($params['password'])) {
            Auth::login($teacher);

            FlashMessage::success('Login realizado com sucesso!');
            $this->redirectTo(route('problems.index'));
        } else {
            FlashMessage::danger('Email e/ou senha inválidos!');
            $this->redirectTo(route('teachers.login'));
        }
    }

    public function destroy(): void
    {
        Auth::logout();
        FlashMessage::success('Logout realizado com sucesso!');
        $this->redirectTo(route('teachers.login'));
    }
}
