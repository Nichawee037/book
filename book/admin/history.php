<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php'; requireAdmin();
require_once __DIR__ . '/../classes/Borrowing.php';
$rows=(new Borrowing())->history();
?><!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>ประวัติการยืมคืน</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/style.css"></head>
<body><nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="index.php">⚙️ แอดมิน</a><div><a class="btn btn-sm btn-outline-light" href="index.php">Dashboard</a> <a class="btn btn-sm btn-outline-light" href="active.php">รายการยืม</a> <a class="btn btn-sm btn-danger" href="logout.php">ออก</a></div></div></nav>
<main class="container py-4"><h2>ประวัติการยืมและคืน</h2><div class="card shadow-sm"><div class="table-responsive"><table class="table table-bordered mb-0"><thead class="table-light"><tr><th>ผู้ยืม</th><th>สมุด</th><th>จำนวน</th><th>ยืม</th><th>กำหนดคืน</th><th>คืนจริง</th><th>สถานะ</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['borrower_name'])?></td><td><?=htmlspecialchars($r['book_name'])?></td><td><?= (int)$r['quantity'] ?></td><td><?=htmlspecialchars(Borrowing::formatDate($r['borrowed_at']))?></td><td><?=htmlspecialchars(Borrowing::formatDate($r['due_at']))?></td><td><?=$r['returned_at']?htmlspecialchars(Borrowing::formatDate($r['returned_at'])):'-'?></td><td><?=$r['status']==='returned'?'<span class="badge bg-success">คืนแล้ว</span>':'<span class="badge bg-warning text-dark">กำลังยืม</span>'?></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="7" class="text-center py-4">ยังไม่มีประวัติ</td></tr><?php endif; ?></tbody></table></div></div></main></body></html>