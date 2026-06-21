<h1>Edit Category</h1>

<form action="<?= BASE_PATH ?>/categories/edit" method="POST">
    <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
    
    <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" name="category_name" id="category_name" class="form-control" value="<?= htmlspecialchars($category['category_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="<?= BASE_PATH ?>/categories" class="btn btn-secondary">Cancel</a>
    </div>
</form>
