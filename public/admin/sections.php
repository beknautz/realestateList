<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdmin();

$pdo = db();
$pageId = (int) ($_REQUEST['page_id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($action === 'create_section') {
    $stmt = $pdo->prepare('INSERT INTO page_sections (page_id, heading, body, cta_label, cta_url, sort_order) VALUES (:page_id, :heading, :body, :cta_label, :cta_url, :sort_order)');
    $stmt->execute([
        'page_id' => $pageId,
        'heading' => trim($_POST['heading'] ?? ''),
        'body' => trim($_POST['body'] ?? ''),
        'cta_label' => trim($_POST['cta_label'] ?? ''),
        'cta_url' => trim($_POST['cta_url'] ?? ''),
        'sort_order' => (int) ($_POST['sort_order'] ?? 10),
    ]);
}

if ($action === 'update_section') {
    $stmt = $pdo->prepare('UPDATE page_sections SET heading = :heading, body = :body, cta_label = :cta_label, cta_url = :cta_url, sort_order = :sort_order WHERE id = :id AND page_id = :page_id');
    $stmt->execute([
        'id' => (int) $_POST['id'],
        'page_id' => $pageId,
        'heading' => trim($_POST['heading'] ?? ''),
        'body' => trim($_POST['body'] ?? ''),
        'cta_label' => trim($_POST['cta_label'] ?? ''),
        'cta_url' => trim($_POST['cta_url'] ?? ''),
        'sort_order' => (int) ($_POST['sort_order'] ?? 10),
    ]);
}

if ($action === 'delete_section') {
    $stmt = $pdo->prepare('DELETE FROM page_sections WHERE id = :id AND page_id = :page_id');
    $stmt->execute([
        'id' => (int) $_POST['id'],
        'page_id' => $pageId,
    ]);
}

$sectionsStmt = $pdo->prepare('SELECT * FROM page_sections WHERE page_id = :page_id ORDER BY sort_order ASC, id ASC');
$sectionsStmt->execute(['page_id' => $pageId]);
$sections = $sectionsStmt->fetchAll();
?>

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead>
        <tr>
            <th style="width: 16%">Sort</th>
            <th style="width: 24%">Heading</th>
            <th>Body</th>
            <th style="width: 20%">CTA</th>
            <th style="width: 12%">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><input class="form-control form-control-sm" form="sec-<?= (int) $section['id'] ?>" name="sort_order" value="<?= (int) $section['sort_order'] ?>"></td>
                <td><input class="form-control form-control-sm" form="sec-<?= (int) $section['id'] ?>" name="heading" value="<?= h($section['heading']) ?>"></td>
                <td><textarea class="form-control form-control-sm" form="sec-<?= (int) $section['id'] ?>" name="body" rows="3"><?= h($section['body']) ?></textarea></td>
                <td>
                    <input class="form-control form-control-sm mb-1" form="sec-<?= (int) $section['id'] ?>" name="cta_label" placeholder="Label" value="<?= h($section['cta_label']) ?>">
                    <input class="form-control form-control-sm" form="sec-<?= (int) $section['id'] ?>" name="cta_url" placeholder="URL" value="<?= h($section['cta_url']) ?>">
                </td>
                <td>
                    <form id="sec-<?= (int) $section['id'] ?>"
                          hx-post="/admin/sections.php"
                          hx-target="#section-list"
                          hx-swap="innerHTML"
                          class="mb-2">
                        <input type="hidden" name="action" value="update_section">
                        <input type="hidden" name="id" value="<?= (int) $section['id'] ?>">
                        <input type="hidden" name="page_id" value="<?= $pageId ?>">
                        <button class="btn btn-sm btn-outline-primary w-100">Save</button>
                    </form>
                    <form hx-post="/admin/sections.php"
                          hx-target="#section-list"
                          hx-swap="innerHTML"
                          onsubmit="return confirm('Delete this section?')">
                        <input type="hidden" name="action" value="delete_section">
                        <input type="hidden" name="id" value="<?= (int) $section['id'] ?>">
                        <input type="hidden" name="page_id" value="<?= $pageId ?>">
                        <button class="btn btn-sm btn-outline-danger w-100">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
