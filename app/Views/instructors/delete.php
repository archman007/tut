<h1>Delete Instructor</h1>
<p>Are you sure you want to delete instructor <strong><?= htmlspecialchars($instructor['first_name'] . ' ' . $instructor['last_name']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/instructors/delete" method="POST" style="margin-top: 2rem;">
    <input type="hidden" name="instructor_id" value="<?= $instructor['instructor_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Instructor</button>
    <a href="<?= BASE_PATH ?>/instructors" class="btn btn-secondary">No, Cancel</a>
</form>
