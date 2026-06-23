<?php
require_once __DIR__ . '/includes/auth.php';
if (isLoggedIn()) {
    redirectToDashboard($_SESSION['role']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Artisan Market</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600&family=Work+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="auth-screen">
  <aside class="auth-brand">
    <div>
      <div class="eyebrow">Govt. Graduate College Layyah</div>
      <h1 class="wordmark">Artisan&nbsp;Market</h1>
      <p class="tagline">A virtual marketplace where local artisans showcase handmade work and customers buy it directly.</p>
    </div>
    <div>
      <hr class="stitched-rule">
      <p class="roles-note">Phase 1: database, registration, login, and role-based dashboards.</p>
    </div>
  </aside>
  <main class="auth-form-panel">
    <div class="tag-card">
      <div class="grommet">
        <svg viewBox="0 0 24 24" fill="none" stroke="#f1ece0" stroke-width="2"><circle cx="12" cy="12" r="9"/></svg>
      </div>
      <h1>Get started</h1>
      <p class="subtitle">Log in or create a Customer / Seller account.</p>
      <a class="btn-primary" style="display:block; text-align:center; text-decoration:none; box-sizing:border-box; margin-bottom:12px;" href="auth/login.php">Log in</a>
      <a class="btn-primary" style="display:block; text-align:center; text-decoration:none; box-sizing:border-box; background:var(--ink); color:#f1ece0;" href="auth/register.php">Create account</a>
    </div>
  </main>
</div>
</body>
</html>
