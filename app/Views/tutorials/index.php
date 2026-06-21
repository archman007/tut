<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tutorials</h1>
    <div>
        <a href="<?= BASE_PATH ?>/tutorials/create" class="btn btn-primary me-2" data-bs-toggle="tooltip" title="Add a new tutorial">Add Tutorial</a>
        <button type="button" class="btn btn-info text-white" onclick="window.print()" data-bs-toggle="tooltip" title="Print all records to PDF">Print All PDF</button>
    </div>
</div>

<form action="<?= BASE_PATH ?>/tutorials" method="GET" class="mb-3 row g-3">
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>">
            <input type="hidden" name="sort" value="<?= $sort ?>">
            <input type="hidden" name="dir" value="<?= $dir ?>">
            <input type="hidden" name="limit" value="<?= $limit ?>">
            <button type="submit" class="btn btn-outline-secondary">Search</button>
            <a href="<?= BASE_PATH ?>/tutorials" class="btn btn-outline-danger">Clear</a>
        </div>
    </div>
    <div class="col-md-2">
        <select name="limit" class="form-select" onchange="this.form.submit()">
            <?php foreach ([5, 10, 20, 50, 100] as $val): ?>
                <option value="<?= $val ?>" <?= $limit == $val ? 'selected' : '' ?>><?= $val ?> per page</option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<?php 
function sortLink($column, $currentSort, $currentDir, $search, $limit) {
    $newDir = ($currentSort === $column && $currentDir === 'ASC') ? 'DESC' : 'ASC';
    $params = http_build_query(['sort' => $column, 'dir' => $newDir, 'search' => $search, 'limit' => $limit]);
    return BASE_PATH . "/tutorials?$params";
}
?>

<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th><a href="<?= sortLink('tutorial_id', $sort, $dir, $search, $limit) ?>" class="text-white text-decoration-none">ID<?= ($sort === 'tutorial_id') ? ($dir === 'ASC' ? ' ▲' : ' ▼') : '' ?></a></th>
            <th><a href="<?= sortLink('title', $sort, $dir, $search, $limit) ?>" class="text-white text-decoration-none">Title<?= ($sort === 'title') ? ($dir === 'ASC' ? ' ▲' : ' ▼') : '' ?></a></th>
            <th>Instructor</th>
            <th>Category</th>
            <th><a href="<?= sortLink('difficulty', $sort, $dir, $search, $limit) ?>" class="text-white text-decoration-none">Difficulty<?= ($sort === 'difficulty') ? ($dir === 'ASC' ? ' ▲' : ' ▼') : '' ?></a></th>
            <th><a href="<?= sortLink('publish_date', $sort, $dir, $search, $limit) ?>" class="text-white text-decoration-none">Date<?= ($sort === 'publish_date') ? ($dir === 'ASC' ? ' ▲' : ' ▼') : '' ?></a></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tutorials as $tutorial): ?>
        <tr>
            <td><?= $tutorial['tutorial_id'] ?></td>
            <td><?= htmlspecialchars($tutorial['title']) ?></td>
            <td><?= htmlspecialchars(($tutorial['first_name'] ?? '') . ' ' . ($tutorial['last_name'] ?? '')) ?></td>
            <td><?= htmlspecialchars($tutorial['category_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($tutorial['difficulty']) ?></td>
            <td><?= htmlspecialchars($tutorial['publish_date'] ?? '') ?></td>
            <td>
                <a href="<?= BASE_PATH ?>/tutorials/delete/<?= $tutorial['tutorial_id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Tutorial">Delete</a>
                <a href="<?= BASE_PATH ?>/tutorials/edit/<?= $tutorial['tutorial_id'] ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Edit Tutorial">Edit</a>
                <?php if (!empty($tutorial['source_url'])): ?>
                    <a href="<?= htmlspecialchars($tutorial['source_url']) ?>" target="_blank" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Launch Tutorial">Launch</a>
                <?php endif; ?>
                <button type="button" class="btn btn-sm btn-info text-white" onclick="window.print()" data-bs-toggle="tooltip" title="Print to PDF">PDF</button>
            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
@media print {
    .navbar, .btn, form, nav.pagination {
        display: none !important;
    }
    body {
        padding: 20px;
    }
}
</style>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="<?= BASE_PATH ?>/tutorials?page=<?= $i ?>&sort=<?= $sort ?>&dir=<?= $dir ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
