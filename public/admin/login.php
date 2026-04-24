<?php
require_once __DIR__ . '/../../includes/functions.php';

if (isAdminAuthenticated()) {
    header('Location: /admin/dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (handleAdminLogin($username, $password)) {
        header('Location: /admin/dashboard.php');
        exit;
    }

    $error = 'Invalid credentials. Please try again.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Firman Pollen CMS</h1>
                    <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button class="btn btn-success w-100">Login</button>
                    </form>
                    <p class="small text-muted mt-3 mb-0">Change ADMIN_USER and ADMIN_PASS in environment variables before production.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
