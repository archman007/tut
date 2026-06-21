<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Management</h1>
        <a href="<?= BASE_PATH ?>/admin/users-create" class="btn btn-primary" data-bs-toggle="tooltip" title="Add User">Add User</a>
    </div>

    <table class="table table-striped table-hover table-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role_name'] ?? 'None') ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <a href="<?= BASE_PATH ?>/admin/users-edit/<?= $user['user_id'] ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit User">Edit</a>
                    <a href="<?= BASE_PATH ?>/admin/users-delete/<?= $user['user_id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete User">Delete</a>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
