<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Videos</h1>
    <a href="<?= BASE_PATH ?>/videos/create" class="btn btn-primary">Add Video</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Tutorial</th>
            <th>Ep #</th>
            <th>URL</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($videos as $video): ?>
        <tr>
            <td><?= $video['video_id'] ?></td>
            <td><?= htmlspecialchars($video['title']) ?></td>
            <td><?= htmlspecialchars($video['tutorial_title'] ?? '') ?></td>
            <td><?= $video['episode_number'] ?></td>
            <td><a href="<?= htmlspecialchars($video['video_url']) ?>" target="_blank" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-title="Watch">Link</a></td>
            <td>
                <a href="<?= BASE_PATH ?>/videos/edit/<?= $video['video_id'] ?>" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit Video">Edit</a>
                <a href="<?= BASE_PATH ?>/videos/delete/<?= $video['video_id'] ?>" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete Video">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
