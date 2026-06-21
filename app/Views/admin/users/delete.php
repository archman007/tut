<h1>Delete User</h1>

<p>Are you sure you want to delete user: <strong><?= htmlspecialchars($user['username']) ?></strong>?</p>

<form action="<?= BASE_PATH ?>/admin/users-destroy" method="POST">
    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete</button>
    <a href="<?= BASE_PATH ?>/admin/users" class="btn btn-secondary">No, Cancel</a>
</form>
