<h1>Edit Playlist</h1>

<form action="<?= BASE_PATH ?>/playlists/edit" method="POST">
    <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id'] ?>">
    
    <div class="mb-3">
        <label for="playlist_name" class="form-label">Playlist Name</label>
        <input type="text" name="playlist_name" id="playlist_name" class="form-control" value="<?= htmlspecialchars($playlist['playlist_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($playlist['description'] ?? '') ?></textarea>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Playlist</button>
        <a href="<?= BASE_PATH ?>/playlists" class="btn btn-secondary">Cancel</a>
    </div>
</form>
