<h1>Delete Tag</h1>
<p>Are you sure you want to delete tag <strong><?= htmlspecialchars($tag['tag_name']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/tags/delete" method="POST" style="margin-top: 2rem;">
    <input type="hidden" name="tag_id" value="<?= $tag['tag_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Tag</button>
    <a href="<?= BASE_PATH ?>/tags" class="btn btn-secondary">No, Cancel</a>
</form>
