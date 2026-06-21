<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Brooks Computing Systems - Jacksonville' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_PATH ?>/css/style.css">
</head>
<body>
    <header class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="<?= BASE_PATH ?>/" class="navbar-brand">Brooks Computing Systems - Jacksonville</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if ($currentUser): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/instructors">Instructors</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/categories">Categories</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/tutorials">Tutorials</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/videos">Videos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/tags">Tags</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/playlists">Playlists</a></li>
                        <?php if (in_array('manage_users', $userPermissions)): ?>
                            <li class="nav-item"><a class="nav-link text-warning" href="<?= BASE_PATH ?>/admin">Admin</a></li>
                        <?php endif; ?>
                        <li class="nav-item d-flex align-items-center ms-3">
                            <span class="text-white me-3">Welcome, <?= htmlspecialchars($currentUser['username']) ?></span>
                            <a href="<?= BASE_PATH ?>/logout" class="btn btn-sm btn-outline-danger">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_PATH ?>/register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>
    <main class="container">
