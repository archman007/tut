<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Categories</h1>
        <a href="<?= BASE_PATH ?>/categories-create" class="btn btn-primary" data-bs-toggle="tooltip" title="Add Category">Add Category</a>
    </div>

    <table class="table table-striped table-hover table-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['category_id'] ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td><?= htmlspecialchars($category['description']) ?></td>
                <td>
                    <a href="<?= BASE_PATH ?>/categories/edit/<?= $category['category_id'] ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit Category">Edit</a>
                    <a href="<?= BASE_PATH ?>/categories/delete/<?= $category['category_id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Category">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

