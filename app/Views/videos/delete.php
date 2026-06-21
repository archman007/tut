<h1>Delete Video</h1>
<p>Are you sure you want to delete video <strong><?= htmlspecialchars($video['title']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/videos/delete" method="POST" class="mt-4">
    <input type="hidden" name="video_id" value="<?= $video['video_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Video</button>
    <a href="<?= BASE_PATH ?>/videos" class="btn btn-secondary">No, Cancel</a>
</form>
