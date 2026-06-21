<?php

namespace App\Controllers;

class BaseController {
    protected $currentUser = null;
    protected $userPermissions = [];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            $this->currentUser = $_SESSION['user'];
            $this->userPermissions = $_SESSION['permissions'] ?? [];
        }
    }

    protected function requireLogin() {
        if (!$this->currentUser) {
            $this->redirect('/login');
        }
    }

    protected function hasPermission($permission) {
        return in_array($permission, $this->userPermissions);
    }

    protected function requirePermission($permission) {
        $this->requireLogin();
        if (!$this->hasPermission($permission)) {
            die("Unauthorized: You do not have permission to perform this action.");
        }
    }

    protected function render($view, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . "/../Views/$view.php";
        
        if (file_exists($viewFile)) {
            $currentUser = $this->currentUser;
            $userPermissions = $this->userPermissions;
            require __DIR__ . "/../Views/layout/header.php";
            require $viewFile;
            require __DIR__ . "/../Views/layout/footer.php";
        } else {
            die("View $view not found.");
        }
    }

    protected function redirect($url) {
        if (strpos($url, '/') === 0) {
            $url = BASE_PATH . $url;
        }
        header("Location: $url");
        exit;
    }
}
