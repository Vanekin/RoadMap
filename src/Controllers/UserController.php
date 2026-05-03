<?php

namespace RoadMap\Controllers;

use RoadMap\Core\Controller;
use RoadMap\Models\User;
use RoadMap\Core\Attributes\Route;
use RoadMap\Core\Exceptions\DataBaseException;

class UserController extends Controller
{
    private User $userModel;

    public function __construct($router)
    {
        parent::__construct($router);
        $this->userModel = new User();
    }
    #[Route('/register', method: 'GET')]
    public function showRegisterForm(): void
    {
        $this->render('user/register', [
            'pageTitle' => 'Регистрация'
        ]);
    }
    #[Route('/register/store', method: 'POST')]
    public function register(): void
    {
        if ($this->getMethod() !== 'POST') {
            $this->redirect('/register');
            return;
        }

        $name = $this->getRequestParams()['name'];
        $surname = $this->getRequestParams()['surname'];
        $email = $this->getRequestParams()['email'];
        $password = $this->getRequestParams()['password'];
        $passwordConfirm = $this->getRequestParams()['password_confirm'];

        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Имя обязательно';
        }

        if (empty($surname)) {
            $errors['surname'] = 'Фамилия обязательна';
        }

        if (empty($email)) {
            $errors['email'] = 'Email обязателен';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный email';
        }

        if (empty($password)) {
            $errors['password'] = 'Пароль обязателен';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Пароль должен быть не менее 6 символов';
        }

        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Пароли не совпадают';
        }

        $existingUser = $this->userModel->findByEmail($email);
        if ($existingUser) {
            $errors['email'] = 'Пользователь с таким email уже существует';
        }

        if (!empty($errors)) {
            $_SESSION['old'] = [
                'name' => $name,
                'surname' => $surname,
                'email' => $email
            ];
            $_SESSION['errors'] = $errors;
            $this->redirect('/register');
            return;
        }

        $userId = $this->userModel->create($name, $surname, $email, $password);

        if ($userId) {
            $_SESSION['user'] = [
                'id' => $userId,
                'name' => $name,
                'surname' => $surname,
                'email' => $email
            ];
            $this->redirect('/profile');
        }
    }
    #[Route('/login', method: 'GET')]
    public function showLoginForm(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/profile');
            return;
        }

        $this->render('user/login', [
            'pageTitle' => 'Вход'
        ]);
    }
    #[Route('/login', method: 'POST')]
    public function login(): void
    {
        if ($this->getMethod() !== 'POST') {
            $this->redirect('/login');
            return;
        }

        $email = $this->getRequestParams()['email'];
        $password = $this->getRequestParams()['password'];

        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Email обязателен';
        }
        if (empty($password)) {
            $errors['password'] = 'Пароль обязателен';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
            return;
        }

        $user = $this->userModel->verifyPassword($email, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            $this->redirect('/profile');
        } else {
            $_SESSION['errors'] = ['Неверный email или пароль'];
            $_SESSION['old'] = ['email' => $email];
            $this->redirect('/login');
        }
    }
    #[Route('/profile', method: 'GET')]
    public function profile(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        $user = $_SESSION['user'];

        $this->render('user/profile', [
            'pageTitle' => 'Мой профиль',
            'user' => $user
        ]);
    }
    #[Route('/logout', method: 'GET')]
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }
}
