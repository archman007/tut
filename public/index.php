<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\DashboardController;
use App\Controllers\InstructorController;
use App\Controllers\CategoryController;
use App\Controllers\TutorialController;
use App\Controllers\VideoController;
use App\Controllers\TagController;
use App\Controllers\PlaylistController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

$script_name = $_SERVER['SCRIPT_NAME']; 
$base_path = dirname($script_name);
if ($base_path === DIRECTORY_SEPARATOR || $base_path === '.') {
    $base_path = '';
}
define('BASE_PATH', $base_path);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Strip base_path from the beginning of the URI
if (BASE_PATH && strpos($uri, BASE_PATH) === 0) {
    $uri = substr($uri, strlen(BASE_PATH));
}

// Strip /index.php if it's there (for environments without mod_rewrite)
if (strpos($uri, '/index.php') === 0) {
    $uri = substr($uri, 10);
}
if (!$uri) $uri = '/';

$method = $_SERVER['REQUEST_METHOD'];

try {
    // Simple routing
    if ($uri === '/' || $uri === '/index.php') {
        if (isset($_SESSION['user'])) {
            (new DashboardController())->index();
        } else {
            // Render landing page directly or via a controller
            $title = 'Welcome to Brooks Computing Systems - Jacksonville';
            require __DIR__ . '/../app/Views/layout/header.php';
            require __DIR__ . '/../app/Views/landing.php';
            require __DIR__ . '/../app/Views/layout/footer.php';
        }
    } elseif ($uri === '/login') {
        (new AuthController())->login();
    } elseif ($uri === '/authenticate') {
        (new AuthController())->authenticate();
    } elseif ($uri === '/logout') {
        (new AuthController())->logout();
    } elseif ($uri === '/register') {
        (new AuthController())->register();
    } elseif ($uri === '/store-user') {
        (new AuthController())->storeUser();
    } elseif ($uri === '/forgot-password') {
        (new AuthController())->forgotPassword();
    } elseif ($uri === '/reset-password') {
        (new AuthController())->resetPassword();
    } elseif (strpos($uri, '/admin') === 0) {
        $controller = new AdminController();
        $parts = explode('/', trim($uri, '/'));
        $action = $parts[1] ?? 'index';
        
        if ($action === 'index') $controller->index();
        elseif ($action === 'users') $controller->users();
        elseif ($action === 'users-create') $controller->userCreate();
        elseif ($action === 'users-store') $controller->userStore();
        elseif ($action === 'users-edit') $controller->userEdit($parts[2] ?? null);
        elseif ($action === 'users-update') $controller->userUpdate();
        elseif ($action === 'users-delete') $controller->userDelete($parts[2] ?? null);
        elseif ($action === 'users-destroy') $controller->userDestroy();
        elseif ($action === 'roles') $controller->roles();
        elseif ($action === 'roles-update') $controller->rolesUpdate();
        else $controller->index();
    } elseif (strpos($uri, '/instructors') === 0) {
        $controller = new InstructorController();
        handle_resource($controller, $uri, $method);
    } elseif (strpos($uri, '/categories') === 0) {
        $controller = new CategoryController();
        handle_resource($controller, $uri, $method);
    } elseif (strpos($uri, '/tutorials') === 0) {
        $controller = new TutorialController();
        if ($uri === '/tutorials/fetch-metadata') {
            $controller->fetchMetadata();
        } else {
            handle_resource($controller, $uri, $method);
        }
    } elseif (strpos($uri, '/videos') === 0) {
        $controller = new VideoController();
        handle_resource($controller, $uri, $method);
    } elseif (strpos($uri, '/tags') === 0) {
        $controller = new TagController();
        handle_resource($controller, $uri, $method);
    } elseif (strpos($uri, '/playlists') === 0) {
        $controller = new PlaylistController();
        if ($uri === '/playlists/add-video' && $method === 'POST') {
            $controller->addVideo();
        } elseif ($uri === '/playlists/remove-video' && $method === 'POST') {
            $controller->removeVideo();
        } else {
            handle_resource($controller, $uri, $method);
        }
    } else {
        http_response_code(404);
        echo "404 Not Found";
    }
} catch (\Exception $e) {
    echo "<h1>Database Connection Error</h1>";
    echo "<p>Please check your .env file and ensure the database is running.</p>";
    if (ini_get('display_errors')) {
        echo "<pre>" . $e->getMessage() . "</pre>";
    }
}

function handle_resource($controller, $uri, $method) {
    $parts = explode('/', trim($uri, '/'));
    $action = $parts[1] ?? 'index';
    $id = $parts[2] ?? null; // Extract ID from URL

    if ($method === 'POST') {
        if ($action === 'create') {
            $controller->store();
        } elseif ($action === 'edit') {
            $controller->update(); // Can still use $_POST['id']
        } elseif ($action === 'delete') {
            $controller->destroy(); // Can still use $_POST['id']
        } else {
            $controller->store();
        }
    } else {
        if ($action === 'index' || $action === '') {
            $controller->index();
        } elseif ($action === 'create') {
            $controller->create();
        } elseif ($action === 'edit') {
            $controller->edit($id);
        } elseif ($action === 'show') {
            $controller->show($id);
        } elseif ($action === 'delete') {
            $controller->delete($id);
        } else {
            $controller->index();
        }
    }
}
