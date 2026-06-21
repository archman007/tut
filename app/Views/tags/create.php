<h1>Add New Tag</h1>

<form action="<?= BASE_PATH ?>/tags/create" method="POST">
    <div class="mb-3">
        <label for="tag_name" class="form-label">Tag Name</label>
        <input type="text" name="tag_name" id="tag_name" class="form-control" required>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Save Tag</button>
        <a href="<?= BASE_PATH ?>/tags" class="btn btn-secondary">Cancel</a>
    </div>
</form>
