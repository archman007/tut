<div class="d-flex justify-content-between align-items-center mb-3">
    <h1><?= htmlspecialchars($playlist['playlist_name']) ?></h1>
    <div>
        <a href="<?= BASE_PATH ?>/playlists" class="btn btn-secondary">Back to Playlists</a>
        <a href="<?= BASE_PATH ?>/playlists/edit/<?= $playlist['playlist_id'] ?>" class="btn btn-warning">Edit</a>
    </div>
</div>

<?php if ($playlist['description']): ?>
    <p class="text-muted mb-4"><?= htmlspecialchars($playlist['description']) ?></p>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <h3>Videos in this Playlist</h3>

        <?php if (empty($videos)): ?>
            <div class="alert alert-info">No videos in this playlist yet. Add some from the list on the right.</div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Tutorial</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($videos as $video): ?>
                    <tr>
                        <td><?= $video['sequence_number'] ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($video['video_url']) ?>" target="_blank">
                                <?= htmlspecialchars($video['title']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($video['tutorial_title'] ?? '') ?></td>
                        <td>
                            <?php if ($video['duration_seconds']): ?>
                                <?= gmdate('H:i:s', $video['duration_seconds']) ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?= BASE_PATH ?>/playlists/remove-video" method="POST" style="display:inline">
                                <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id'] ?>">
                                <input type="hidden" name="video_id" value="<?= $video['video_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Remove from playlist">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add Video</h5>
            </div>
            <div class="card-body">
                <?php if (empty($availableVideos)): ?>
                    <p class="text-muted mb-0">All videos are already in this playlist.</p>
                <?php else: ?>
                    <form action="<?= BASE_PATH ?>/playlists/add-video" method="POST">
                        <input type="hidden" name="playlist_id" value="<?= $playlist['playlist_id'] ?>">
                        <div class="mb-3">
                            <select name="video_id" class="form-select" required>
                                <option value="">-- Select a video --</option>
                                <?php foreach ($availableVideos as $video): ?>
                                    <option value="<?= $video['video_id'] ?>">
                                        <?= htmlspecialchars($video['title']) ?>
                                        (<?= htmlspecialchars($video['tutorial_title'] ?? '') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add to Playlist</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
