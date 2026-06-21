<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="<?= BASE_PATH ?>/admin/users" class="card text-decoration-none h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title h4">Users</h2>
                    <p class="card-text text-muted"><?= $usersCount ?> registered users.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="<?= BASE_PATH ?>/admin/roles" class="card text-decoration-none h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title h4">Roles & Permissions</h2>
                    <p class="card-text text-muted"><?= $rolesCount ?> roles defined.</p>
                </div>
            </a>
        </div>
    </div>
</div>
