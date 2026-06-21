<div class="container">
    <h1 class="mb-4">Welcome to the Brooks Computing Systems - Jacksonville Admin</h1>
    <p class="mb-4">Select a section to manage your data:</p>

    <div class="row g-4">
        <?php if (in_array('view_dashboard', $userPermissions)): ?>
            <?php
            $sections = [
                ['url' => 'instructors', 'title' => 'Instructors', 'desc' => 'Manage tutorial authors and their contact info.'],
                ['url' => 'categories', 'title' => 'Categories', 'desc' => 'Organize tutorials by topic and description.'],
                ['url' => 'tutorials', 'title' => 'Tutorials', 'desc' => 'The main library of tutorials and their metadata.'],
                ['url' => 'videos', 'title' => 'Videos', 'desc' => 'Manage individual video episodes for tutorials.'],
                ['url' => 'tags', 'title' => 'Tags', 'desc' => 'Label and categorize tutorials with keywords.'],
                ['url' => 'playlists', 'title' => 'Playlists', 'desc' => 'Group videos together into curated collections.'],
            ];
            ?>
            <?php foreach ($sections as $section): ?>
                <div class="col-md-4">
                    <a href="<?= BASE_PATH ?>/<?= $section['url'] ?>" class="card text-decoration-none h-100 shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title h4"><?= $section['title'] ?></h2>
                            <p class="card-text text-muted"><?= $section['desc'] ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">You do not have permission to view the dashboard contents. Please contact an administrator.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
