<h1>Add New Instructor</h1>

<form action="<?= BASE_PATH ?>/instructors/create" method="POST">
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mb-3">
        <label for="website" class="form-label">Website</label>
        <input type="url" name="website" id="website" class="form-control">
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Save Instructor</button>
        <a href="<?= BASE_PATH ?>/instructors" class="btn btn-secondary">Cancel</a>
    </div>
</form>
