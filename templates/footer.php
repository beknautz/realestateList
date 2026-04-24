<?php
$footer = getSetting('footer_text', '© ' . date('Y') . ' Firman Pollen. Built for modern growers.');
?>
<footer class="py-5 mt-5 border-top bg-light">
    <div class="container d-flex flex-column flex-lg-row justify-content-between align-items-center gap-2">
        <p class="mb-0 text-muted"><?= h($footer) ?></p>
        <small class="text-muted">Powered by PHP + HTMX + Bootstrap + MySQL.</small>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
