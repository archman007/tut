<h1>Edit Video</h1>

<form action="<?= BASE_PATH ?>/videos/edit" method="POST">
    <input type="hidden" name="video_id" value="<?= $video['video_id'] ?>">
    
    <div class="mb-3">
        <label for="tutorial_id" class="form-label">Tutorial</label>
        <select name="tutorial_id" id="tutorial_id" class="form-select" required>
            <option value="">Select Tutorial</option>
            <?php foreach ($tutorials as $tutorial): ?>
            <option value="<?= $tutorial['tutorial_id'] ?>" <?= $tutorial['tutorial_id'] == $video['tutorial_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($tutorial['title']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($video['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="episode_number" class="form-label">Episode Number</label>
        <input type="number" name="episode_number" id="episode_number" class="form-control" value="<?= $video['episode_number'] ?>">
    </div>
    <div class="mb-3">
        <label for="video_url" class="form-label">Video URL</label>
        <input type="url" name="video_url" id="video_url" class="form-control" value="<?= htmlspecialchars($video['video_url']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="duration_seconds" class="form-label">Duration (seconds)</label>
        <input type="number" name="duration_seconds" id="duration_seconds" class="form-control" value="<?= $video['duration_seconds'] ?>">
    </div>
    <div class="mb-3">
        <label for="transcript" class="form-label">Transcript</label>
        <textarea name="transcript" id="transcript" class="form-control" rows="6"><?= htmlspecialchars($video['transcript'] ?? '') ?></textarea>
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Video</button>
        <a href="<?= BASE_PATH ?>/videos" class="btn btn-secondary">Cancel</a>
    </div>
</form>
