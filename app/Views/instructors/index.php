<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Instructors</h1>
    <a href="<?= BASE_PATH ?>/instructors/create" class="btn btn-primary" data-bs-toggle="tooltip" title="Add Instructor">Add Instructor</a>
</div>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Website</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($instructors as $instructor): ?>
        <tr>
            <td><?= $instructor['instructor_id'] ?></td>
            <td><?= htmlspecialchars($instructor['first_name'] . ' ' . $instructor['last_name']) ?></td>
            <td><?= htmlspecialchars($instructor['email'] ?? '') ?></td>
            <td><?= htmlspecialchars($instructor['website'] ?? '') ?></td>
            <td>
                <a href="<?= BASE_PATH ?>/instructors/edit/<?= $instructor['instructor_id'] ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit Instructor">Edit</a>
                <a href="<?= BASE_PATH ?>/instructors/delete/<?= $instructor['instructor_id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Instructor">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
