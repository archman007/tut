<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Playlists</h1>
    <a href="<?= BASE_PATH ?>/playlists/create" class="btn btn-primary">Add Playlist</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($playlists as $playlist): ?>
        <tr>
            <td><?= $playlist['playlist_id'] ?></td>
            <td><a href="<?= BASE_PATH ?>/playlists/show/<?= $playlist['playlist_id'] ?>"><?= htmlspecialchars($playlist['playlist_name']) ?></a></td>
            <td><?= htmlspecialchars($playlist['description'] ?? '') ?></td>
            <td>
                <a href="<?= BASE_PATH ?>/playlists/show/<?= $playlist['playlist_id'] ?>" class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-title="View Playlist">View</a>
                <a href="<?= BASE_PATH ?>/playlists/edit/<?= $playlist['playlist_id'] ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit Playlist">Edit</a>
                <a href="<?= BASE_PATH ?>/playlists/delete/<?= $playlist['playlist_id'] ?>" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete Playlist">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
