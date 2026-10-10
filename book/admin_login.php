<?php
declare(strict_types=1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = (string)($_POST['password'] ?? '');
    if (hash_equals('admin123', $password)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin/index.php');
        exit;
    }
    $_SESSION['login_error'] = 'รหัสผ่านไม่ถูกต้อง';
}
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>เข้าสู่ระบบแอดมิน</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="assets/style.css"></head>
<body><main class="container py-5"><div class="row justify-content-center"><div class="col-md-5"><div class="card shadow-sm p-4">
<h3>🔐 เข้าสู่ระบบแอดมิน</h3><?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><label class="form-label">รหัสผ่าน</label><input type="password" name="password" class="form-control mb-3" required><button class="btn btn-dark w-100">เข้าสู่ระบบ</button></form>
<a href="index.html" class="btn btn-link w-100 mt-2">กลับหน้าหลัก</a></div></div></div></main></body></html>