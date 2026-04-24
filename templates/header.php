<?php
$siteName = getSetting('site_name', 'Firman Pollen');
$tagline = getSetting('site_tagline', 'Precision pollen intelligence for high-performing farms.');
$pages = getPublishedPages();
$currentSlug = $currentSlug ?? 'home';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($pageTitle ?? $siteName) ?></title>
    <meta name="description" content="<?= h($pageDescription ?? $tagline) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top farm-navbar">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="/">
            <i class="bi bi-flower2 me-2"></i><?= h($siteName) ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php foreach ($pages as $navPage): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentSlug === $navPage['slug'] ? 'active' : '' ?>" href="/?page=<?= h($navPage['slug']) ?>">
                            <?= h($navPage['title']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item ms-lg-3"><a href="/admin/login.php" class="btn btn-sm btn-outline-light">CMS</a></li>
            </ul>
        </div>
    </div>
</nav>
