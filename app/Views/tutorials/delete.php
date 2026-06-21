<h1>Delete Tutorial</h1>
<p>Are you sure you want to delete tutorial <strong><?= htmlspecialchars($tutorial['title']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/tutorials/delete" method="POST" style="margin-top: 2rem;">
    <input type="hidden" name="tutorial_id" value="<?= $tutorial['tutorial_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Tutorial</button>
    <a href="<?= BASE_PATH ?>/tutorials" class="btn btn-secondary">No, Cancel</a>
</form>
