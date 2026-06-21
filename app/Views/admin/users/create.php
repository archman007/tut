<h1>Add User</h1>

<form action="<?= BASE_PATH ?>/admin/users-store" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="form-group">
        <label for="role_id">Role</label>
        <select name="role_id" id="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="<?= BASE_PATH ?>/admin/users" class="btn btn-secondary">Cancel</a>
    </div>
</form>
