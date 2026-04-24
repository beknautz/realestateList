<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$pdo = db();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create_page') {
        $stmt = $pdo->prepare('INSERT INTO pages (title, slug, meta_description, hero_title, hero_subtitle, is_published) VALUES (:title, :slug, :meta_description, :hero_title, :hero_subtitle, :is_published)');
        $stmt->execute([
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'hero_title' => trim($_POST['hero_title'] ?? ''),
            'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);
        $message = 'Page created.';
    }

    if ($action === 'update_page') {
        $stmt = $pdo->prepare('UPDATE pages SET title = :title, slug = :slug, meta_description = :meta_description, hero_title = :hero_title, hero_subtitle = :hero_subtitle, is_published = :is_published WHERE id = :id');
        $stmt->execute([
            'id' => (int) $_POST['id'],
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'meta_description' => trim($_POST['meta_description'] ?? ''),
            'hero_title' => trim($_POST['hero_title'] ?? ''),
            'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
        ]);
        $message = 'Page updated.';
    }

    if ($action === 'delete_page') {
        $stmt = $pdo->prepare('DELETE FROM pages WHERE id = :id');
        $stmt->execute(['id' => (int) $_POST['id']]);
        $message = 'Page deleted.';
    }

    if ($action === 'save_settings') {
        $settings = [
            'site_name' => trim($_POST['site_name'] ?? ''),
            'site_tagline' => trim($_POST['site_tagline'] ?? ''),
            'footer_text' => trim($_POST['footer_text'] ?? ''),
        ];
        $stmt = $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (:setting_key, :setting_value) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
        foreach ($settings as $key => $value) {
            $stmt->execute(['setting_key' => $key, 'setting_value' => $value]);
        }
        $message = 'Settings saved.';
    }
}

$pages = $pdo->query('SELECT * FROM pages ORDER BY id ASC')->fetchAll();
$selectedPageId = (int) ($_GET['page_id'] ?? ($pages[0]['id'] ?? 0));
$selectedPage = null;
foreach ($pages as $p) {
    if ((int) $p['id'] === $selectedPageId) {
        $selectedPage = $p;
    }
}
if (!$selectedPage && $pages) {
    $selectedPage = $pages[0];
    $selectedPageId = (int) $selectedPage['id'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
</head>
<body class="bg-light-subtle">
<nav class="navbar navbar-dark bg-success">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Firman Pollen CMS</span>
        <div>
            <a href="/" class="btn btn-sm btn-outline-light">View Site</a>
            <a href="/admin/logout.php" class="btn btn-sm btn-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <?php if ($message): ?><div class="alert alert-success"><?= h($message) ?></div><?php endif; ?>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white"><strong>Create Page</strong></div>
                <div class="card-body">
                    <form method="post" class="row g-2">
                        <input type="hidden" name="action" value="create_page">
                        <div class="col-12"><input class="form-control" name="title" placeholder="Title" required></div>
                        <div class="col-12"><input class="form-control" name="slug" placeholder="Slug e.g. about" required></div>
                        <div class="col-12"><input class="form-control" name="meta_description" placeholder="Meta description"></div>
                        <div class="col-12"><input class="form-control" name="hero_title" placeholder="Hero title"></div>
                        <div class="col-12"><textarea class="form-control" name="hero_subtitle" rows="2" placeholder="Hero subtitle"></textarea></div>
                        <div class="col-12 form-check ms-1"><input class="form-check-input" type="checkbox" name="is_published" checked><label class="form-check-label">Published</label></div>
                        <div class="col-12"><button class="btn btn-success w-100">Create</button></div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>Global Settings</strong></div>
                <div class="card-body">
                    <form method="post" class="row g-2">
                        <input type="hidden" name="action" value="save_settings">
                        <div class="col-12"><input class="form-control" name="site_name" value="<?= h(getSetting('site_name', 'Firman Pollen')) ?>" placeholder="Site name"></div>
                        <div class="col-12"><textarea class="form-control" name="site_tagline" rows="2" placeholder="Tagline"><?= h(getSetting('site_tagline')) ?></textarea></div>
                        <div class="col-12"><textarea class="form-control" name="footer_text" rows="2" placeholder="Footer text"><?= h(getSetting('footer_text')) ?></textarea></div>
                        <div class="col-12"><button class="btn btn-outline-success w-100">Save Settings</button></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <strong>Page List</strong>
                    <small class="text-muted">Click page title to load sections</small>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach ($pages as $item): ?>
                        <a class="list-group-item list-group-item-action d-flex justify-content-between <?= $selectedPageId === (int) $item['id'] ? 'active' : '' ?>" href="/admin/dashboard.php?page_id=<?= (int) $item['id'] ?>">
                            <span><?= h($item['title']) ?> <small class="text-muted">/<?= h($item['slug']) ?></small></span>
                            <span class="badge text-bg-<?= $item['is_published'] ? 'success' : 'secondary' ?>"><?= $item['is_published'] ? 'Published' : 'Draft' ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($selectedPage): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white"><strong>Edit Page: <?= h($selectedPage['title']) ?></strong></div>
                    <div class="card-body">
                        <form method="post" class="row g-2">
                            <input type="hidden" name="action" value="update_page">
                            <input type="hidden" name="id" value="<?= (int) $selectedPage['id'] ?>">
                            <div class="col-md-6"><input class="form-control" name="title" value="<?= h($selectedPage['title']) ?>" required></div>
                            <div class="col-md-6"><input class="form-control" name="slug" value="<?= h($selectedPage['slug']) ?>" required></div>
                            <div class="col-12"><input class="form-control" name="meta_description" value="<?= h($selectedPage['meta_description']) ?>"></div>
                            <div class="col-12"><input class="form-control" name="hero_title" value="<?= h($selectedPage['hero_title']) ?>"></div>
                            <div class="col-12"><textarea class="form-control" name="hero_subtitle" rows="2"><?= h($selectedPage['hero_subtitle']) ?></textarea></div>
                            <div class="col-12 form-check ms-1"><input class="form-check-input" type="checkbox" name="is_published" <?= $selectedPage['is_published'] ? 'checked' : '' ?>><label class="form-check-label">Published</label></div>
                            <div class="col-md-8"><button class="btn btn-primary">Save Page</button></div>
                        </form>
                        <form method="post" class="mt-2" onsubmit="return confirm('Delete this page and all sections?')">
                            <input type="hidden" name="action" value="delete_page">
                            <input type="hidden" name="id" value="<?= (int) $selectedPage['id'] ?>">
                            <button class="btn btn-outline-danger btn-sm">Delete Page</button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white"><strong>Page Sections (HTMX)</strong></div>
                    <div class="card-body">
                        <form class="row g-2 mb-3"
                              hx-post="/admin/sections.php"
                              hx-target="#section-list"
                              hx-swap="innerHTML">
                            <input type="hidden" name="action" value="create_section">
                            <input type="hidden" name="page_id" value="<?= (int) $selectedPage['id'] ?>">
                            <div class="col-md-6"><input class="form-control" name="heading" placeholder="Section heading" required></div>
                            <div class="col-md-6"><input class="form-control" name="sort_order" type="number" placeholder="Sort order" value="10"></div>
                            <div class="col-12"><textarea class="form-control" name="body" rows="3" placeholder="Section body" required></textarea></div>
                            <div class="col-md-6"><input class="form-control" name="cta_label" placeholder="CTA label"></div>
                            <div class="col-md-6"><input class="form-control" name="cta_url" placeholder="CTA URL"></div>
                            <div class="col-12"><button class="btn btn-success">Add Section</button></div>
                        </form>
                        <div id="section-list"
                             hx-get="/admin/sections.php?page_id=<?= (int) $selectedPage['id'] ?>"
                             hx-trigger="load">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
