<?php

require_once __DIR__ . '/db.php';

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function getSetting(string $key, string $fallback = ''): string
{
    $stmt = db()->prepare('SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1');
    $stmt->execute(['key' => $key]);
    $row = $stmt->fetch();

    return $row['setting_value'] ?? $fallback;
}

function getPageBySlug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM pages WHERE slug = :slug AND is_published = 1 LIMIT 1');
    $stmt->execute(['slug' => $slug]);
    $page = $stmt->fetch();

    if (!$page) {
        return null;
    }

    $sectionStmt = db()->prepare('SELECT * FROM page_sections WHERE page_id = :page_id ORDER BY sort_order ASC, id ASC');
    $sectionStmt->execute(['page_id' => $page['id']]);
    $page['sections'] = $sectionStmt->fetchAll();

    return $page;
}

function getPublishedPages(): array
{
    return db()->query('SELECT id, title, slug FROM pages WHERE is_published = 1 ORDER BY id ASC')->fetchAll();
}

function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isAdminAuthenticated(): bool
{
    startSession();
    return !empty($_SESSION['admin_authenticated']);
}

function requireAdmin(): void
{
    if (!isAdminAuthenticated()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function handleAdminLogin(string $username, string $password): bool
{
    $config = require __DIR__ . '/../config.php';

    if (
        hash_equals($config['admin']['username'], $username)
        && hash_equals($config['admin']['password'], $password)
    ) {
        startSession();
        $_SESSION['admin_authenticated'] = true;
        return true;
    }

    return false;
}
