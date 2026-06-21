<h1>Edit Tutorial</h1>

<form action="<?= BASE_PATH ?>/tutorials/edit" method="POST">
    <input type="hidden" name="tutorial_id" value="<?= $tutorial['tutorial_id'] ?>">
    
    <div class="form-group">
        <label for="title">Title (Paste a URL and click Fetch to auto-populate)</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($tutorial['title']) ?>" required style="flex-grow: 1;">
            <button type="button" id="fetch-btn" class="btn btn-secondary">Fetch</button>
        </div>
        <span id="loader" style="display:none; font-size: 0.8em; color: #007bff;">Fetching metadata...</span>
    </div>
    <div class="form-group">
        <label for="source_url">Source URL</label>
        <input type="text" name="source_url" id="source_url" value="<?= htmlspecialchars($tutorial['source_url'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="thumbnail_url">Thumbnail URL</label>
        <input type="text" name="thumbnail_url" id="thumbnail_url" value="<?= htmlspecialchars($tutorial['thumbnail_url'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" rows="4"><?= htmlspecialchars($tutorial['description'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label for="instructor_id">Instructor</label>
        <select name="instructor_id" id="instructor_id">
            <option value="">Select Instructor</option>
            <?php foreach ($instructors as $instructor): ?>
            <option value="<?= $instructor['instructor_id'] ?>" <?= $instructor['instructor_id'] == $tutorial['instructor_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($instructor['first_name'] . ' ' . $instructor['last_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id">
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $tutorial['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($category['category_name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="difficulty">Difficulty</label>
        <select name="difficulty" id="difficulty">
            <option value="Beginner" <?= $tutorial['difficulty'] == 'Beginner' ? 'selected' : '' ?>>Beginner</option>
            <option value="Intermediate" <?= $tutorial['difficulty'] == 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
            <option value="Advanced" <?= $tutorial['difficulty'] == 'Advanced' ? 'selected' : '' ?>>Advanced</option>
        </select>
    </div>
    <div class="form-group">
        <label for="language">Language</label>
        <input type="text" name="language" id="language" value="<?= htmlspecialchars($tutorial['language']) ?>">
    </div>
    <div class="form-group">
        <label for="duration_minutes">Duration (minutes)</label>
        <input type="number" name="duration_minutes" id="duration_minutes" value="<?= $tutorial['duration_minutes'] ?>">
    </div>
    <div class="form-group">
        <label for="publish_date">Publish Date</label>
        <input type="date" name="publish_date" id="publish_date" value="<?= $tutorial['publish_date'] ?>">
    </div>
    <div style="margin-top: 1rem;">
        <button type="submit" class="btn btn-primary">Update Tutorial</button>
        <a href="<?= BASE_PATH ?>/tutorials" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
document.getElementById('fetch-btn').addEventListener('click', function() {
    const titleField = document.getElementById('title');
    const val = titleField.value.trim();
    const urlPattern = /^(https?:\/\/)/i;
    
    if (!urlPattern.test(val)) {
        alert('Please enter a valid URL starting with http:// or https:// in the Title field first.');
        return;
    }

    const loader = document.getElementById('loader');
    loader.style.display = 'inline';
    this.disabled = true;
    
    fetch('<?= BASE_PATH ?>/tutorials/fetch-metadata?url=' + encodeURIComponent(val))
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                throw new Error('You are not authorized. Please log in again.');
            }
            return response.json();
        })
        .then(data => {
            loader.style.display = 'none';
            this.disabled = false;
            
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }
            
            if (data.title) titleField.value = data.title;
            if (data.description) document.getElementById('description').value = data.description;
            if (data.source_url) document.getElementById('source_url').value = data.source_url;
            if (data.thumbnail_url) document.getElementById('thumbnail_url').value = data.thumbnail_url;
            if (data.publish_date) document.getElementById('publish_date').value = data.publish_date;
            if (data.duration_minutes) document.getElementById('duration_minutes').value = data.duration_minutes;
            if (data.instructor_id) {
                const instructorSelect = document.getElementById('instructor_id');
                let optionExists = false;
                for (let i = 0; i < instructorSelect.options.length; i++) {
                    if (instructorSelect.options[i].value == data.instructor_id) {
                        optionExists = true;
                        break;
                    }
                }
                
                if (!optionExists && data.author_name) {
                    const newOption = new Option(data.author_name, data.instructor_id);
                    instructorSelect.add(newOption);
                }
                instructorSelect.value = data.instructor_id;
            }
        })
        .catch(err => {
            loader.style.display = 'none';
            this.disabled = false;
            alert('An error occurred while fetching metadata: ' + err.message);
        });
});
</script>
