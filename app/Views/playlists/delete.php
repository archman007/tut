<h1>Delete Playlist</h1>
<p>Are you sure you want to delete playlist <strong><?= htmlspecialchars($playlist['playlist_name']) ?></strong>?</p>
<p>This action cannot be undone.</p>

<form action="<?= BASE_PATH ?>/playlists/delete" method="POST" class="mt-4">
    <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id'] ?>">
    <button type="submit" class="btn btn-danger">Yes, Delete Playlist</button>
    <a href="<?= BASE_PATH ?>/playlists" class="btn btn-secondary">No, Cancel</a>
</form>
