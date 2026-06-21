<h1>Edit User</h1>

<form action="<?= BASE_PATH ?>/admin/users-update" method="POST">
    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="form-group">
        <label for="password">Password (leave blank to keep current)</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="form-group">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['role_id'] ?>" <?= $role['role_id'] == $user['role_id'] ? 'selected' : '' ?>><?= $role['role_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="<?= BASE_PATH ?>/admin/users" class="btn btn-secondary">Cancel</a>
    </div>
</form>
