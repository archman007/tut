<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Rbac;

class AuthController extends BaseController {
    private $userModel;
    private $rbacModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->rbacModel = new Rbac();
    }

    public function login() {
        if ($this->currentUser) {
            $this->redirect('/');
        }
        $this->render('auth/login', ['title' => 'Login']);
    }

    public function authenticate() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['permissions'] = $this->rbacModel->getPermissionsByRoleId($user['role_id']);
            $this->redirect('/');
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            $this->redirect('/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    public function register() {
        if ($this->currentUser) {
            $this->redirect('/');
        }
        $this->render('auth/register', ['title' => 'Register']);
    }

    public function storeUser() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            $this->redirect('/register');
        }

        if ($this->userModel->findByUsername($username)) {
            $_SESSION['error'] = "Username already exists.";
            $this->redirect('/register');
        }

        $result = $this->userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role_id' => 3 // Viewer
        ]);

        if ($result) {
            $_SESSION['success'] = "Registration successful. Please login.";
            $this->redirect('/login');
        } else {
            $_SESSION['error'] = "Registration failed.";
            $this->redirect('/register');
        }
    }

    public function forgotPassword() {
        $this->render('auth/forgot_password', ['title' => 'Forgot Password']);
    }

    public function resetPassword() {
        // Mocking password reset flow
        $email = $_POST['email'] ?? '';
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['success'] = "If that email exists in our system, a reset link has been sent.";
        } else {
            $_SESSION['success'] = "If that email exists in our system, a reset link has been sent.";
        }
        $this->redirect('/forgot-password');
    }
}
