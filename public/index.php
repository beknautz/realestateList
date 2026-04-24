<?php
require_once __DIR__ . '/../includes/functions.php';

$slug = preg_replace('/[^a-z0-9\-]/', '', $_GET['page'] ?? 'home');
$page = getPageBySlug($slug);

if (!$page) {
    http_response_code(404);
    $slug = '404';
    $page = [
        'title' => 'Page Not Found',
        'meta_description' => 'This page does not exist.',
        'hero_title' => 'We could not find that crop intel page.',
        'hero_subtitle' => 'Check the menu and keep growing with better data.',
        'sections' => [],
    ];
}

$pageTitle = $page['title'];
$pageDescription = $page['meta_description'] ?? '';
$currentSlug = $slug;

require __DIR__ . '/../templates/header.php';
?>

<header class="hero-gradient py-5 border-bottom">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="text-uppercase small fw-semibold text-success mb-2">Farm Technology Platform</p>
                <h1 class="display-5 fw-bold mb-3"><?= h($page['hero_title'] ?? $page['title']) ?></h1>
                <p class="lead text-secondary"><?= h($page['hero_subtitle'] ?? '') ?></p>
                <a href="/?page=contact" class="btn btn-success btn-lg mt-2">Book an Agronomy Demo</a>
            </div>
            <div class="col-lg-5">
                <div class="glass-card p-4">
                    <h2 class="h5 mb-3">Why growers choose Firman Pollen</h2>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Drone + sensor-ready data workflows</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Field-specific pollen forecasting</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Actionable recommendations in hours</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container py-5">
    <?php foreach ($page['sections'] as $section): ?>
        <section class="mb-5">
            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-3"><?= h($section['heading']) ?></h2>
                    <div class="text-secondary section-body"><?= nl2br(h($section['body'])) ?></div>
                </div>
                <?php if (!empty($section['cta_label']) && !empty($section['cta_url'])): ?>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <p class="text-muted">Ready to apply this in your operation?</p>
                                <a class="btn btn-outline-success" href="<?= h($section['cta_url']) ?>"><?= h($section['cta_label']) ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</main>

<?php require __DIR__ . '/../templates/footer.php'; ?>
