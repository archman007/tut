<h1>Edit Tag</h1>

<form action="<?= BASE_PATH ?>/tags/edit" method="POST">
    <input type="hidden" name="tag_id" value="<?= $tag['tag_id'] ?>">
    
    <div class="mb-3">
        <label for="tag_name" class="form-label">Tag Name</label>
        <input type="text" name="tag_name" id="tag_name" class="form-control" value="<?= htmlspecialchars($tag['tag_name']) ?>" required>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Tag</button>
        <a href="<?= BASE_PATH ?>/tags" class="btn btn-secondary">Cancel</a>
    </div>
</form>
