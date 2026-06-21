<h1>Delete Category</h1>
<p>Are you sure you want to delete category <strong><?= htmlspecialchars($category['category_name']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/categories/delete" method="POST" style="margin-top: 2rem;">
    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Category</button>
    <a href="<?= BASE_PATH ?>/categories" class="btn btn-secondary">No, Cancel</a>
</form>
