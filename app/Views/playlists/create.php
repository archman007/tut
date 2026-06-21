<h1>Add New Playlist</h1>

<form action="<?= BASE_PATH ?>/playlists/create" method="POST">
    <div class="mb-3">
        <label for="playlist_name" class="form-label">Playlist Name</label>
        <input type="text" name="playlist_name" id="playlist_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Save Playlist</button>
        <a href="<?= BASE_PATH ?>/playlists" class="btn btn-secondary">Cancel</a>
    </div>
</form>
