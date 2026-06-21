<h1>Edit Instructor</h1>

<form action="<?= BASE_PATH ?>/instructors/edit" method="POST">
    <input type="hidden" name="instructor_id" value="<?= $instructor['instructor_id'] ?>">
    
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="<?= htmlspecialchars($instructor['first_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="<?= htmlspecialchars($instructor['last_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($instructor['email'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="website" class="form-label">Website</label>
        <input type="url" name="website" id="website" class="form-control" value="<?= htmlspecialchars($instructor['website'] ?? '') ?>">
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Update Instructor</button>
        <a href="<?= BASE_PATH ?>/instructors" class="btn btn-secondary">Cancel</a>
    </div>
</form>
