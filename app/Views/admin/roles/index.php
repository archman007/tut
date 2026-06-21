<h1>Role & Permission Management</h1>

<?php if (isset($_SESSION['success'])): ?>
    <p class="success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<form action="<?= BASE_PATH ?>/admin/roles-update" method="POST">
    <table>
        <thead>
            <tr>
                <th>Permission</th>
                <?php foreach ($roles as $role): ?>
                    <th><?= htmlspecialchars($role['role_name']) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permissions as $perm): ?>
            <tr>
                <td><strong><?= htmlspecialchars($perm['permission_name']) ?></strong><br><small><?= htmlspecialchars($perm['description']) ?></small></td>
                <?php foreach ($roles as $role): ?>
                    <td style="text-align: center;">
                        <input type="checkbox" name="roles[<?= $role['role_id'] ?>][]" value="<?= $perm['permission_id'] ?>" 
                        <?= in_array($perm['permission_id'], $rolePermissions[$role['role_id']]) ? 'checked' : '' ?>>
                    </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="form-actions" style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Permissions</button>
    </div>
</form>
