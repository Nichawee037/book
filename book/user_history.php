<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/classes/Borrowing.php';

$name = trim((string)($_GET['name'] ?? ''));
$rows = [];
$error = '';

try {
    if ($name !== '') {
        $rows = (new Borrowing())->historyByBorrower($name);
    }
} catch (Throwable $e) {
    $error = 'ไม่สามารถอ่านข้อมูลได้ กรุณาตรวจสอบฐานข้อมูล';
}
?>
<!doctype html>
<html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>ผลประวัติการยืม</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="assets/style.css"></head>
<body><nav class="navbar navbar-expand-lg navbar-dark bg-primary"><div class="container"><a class="navbar-brand" href="index.html">📚 ระบบยืม-คืนสมุด</a></div></nav>
<main class="container py-4"><div class="d-flex justify-content-between align-items-center mb-3"><div><h2>ประวัติการยืมของฉัน</h2><p class="text-muted mb-0">ข้อมูลเป็นแบบอ่านอย่างเดียว</p></div><a href="user_history.html" class="btn btn-secondary">ค้นหาใหม่</a></div>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php elseif ($name === ''): ?><div class="alert alert-info">กรุณากรอกชื่อผู้ยืม</div>
<?php elseif (!$rows): ?><div class="alert alert-secondary">ไม่พบประวัติของชื่อ <strong><?= htmlspecialchars($name) ?></strong></div>
<?php else: ?><div class="alert alert-light border">ประวัติของ <strong><?= htmlspecialchars($name) ?></strong></div>
<div class="card shadow-sm"><div class="table-responsive"><table class="table table-bordered mb-0"><thead class="table-light"><tr><th>สมุด</th><th>จำนวน</th><th>วันเวลายืม</th><th>กำหนดคืน</th><th>คืนจริง</th><th>สถานะ</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= htmlspecialchars($r['book_name']) ?></td><td><?= (int)$r['quantity'] ?> เล่ม</td><td><?= htmlspecialchars(Borrowing::formatDate($r['borrowed_at'])) ?></td><td><?= htmlspecialchars(Borrowing::formatDate($r['due_at'])) ?></td><td><?= $r['returned_at'] ? htmlspecialchars(Borrowing::formatDate($r['returned_at'])) : '-' ?></td><td><?= $r['status']==='returned' ? '<span class="badge bg-success">คืนแล้ว</span>' : '<span class="badge bg-warning text-dark">กำลังยืม</span>' ?></td></tr><?php endforeach; ?>
</tbody></table></div></div><?php endif; ?></main></body></html>