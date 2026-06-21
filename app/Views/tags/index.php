<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tags</h1>
    <a href="<?= BASE_PATH ?>/tags/create" class="btn btn-primary" data-bs-toggle="tooltip" title="Add Tag">Add Tag</a>
</div>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tags as $tag): ?>
        <tr>
            <td><?= $tag['tag_id'] ?></td>
            <td><?= htmlspecialchars($tag['tag_name']) ?></td>
            <td>
                <a href="<?= BASE_PATH ?>/tags/edit/<?= $tag['tag_id'] ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit Tag">Edit</a>
                <a href="<?= BASE_PATH ?>/tags/delete/<?= $tag['tag_id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Tag">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
