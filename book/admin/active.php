<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php'; requireAdmin();
require_once __DIR__ . '/../classes/Borrowing.php';
$b = new Borrowing();
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $r=$b->returnBook((int)($_POST['id']??0));
    $_SESSION['admin_message']=$r[1];
    header('Location: active.php'); exit;
}
$rows=$b->active(); $msg=$_SESSION['admin_message']??''; unset($_SESSION['admin_message']);
?><!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>รายการกำลังยืม</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/style.css"></head>
<body><nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="index.php">⚙️ แอดมิน</a><div><a class="btn btn-sm btn-outline-light" href="index.php">Dashboard</a> <a class="btn btn-sm btn-outline-light" href="history.php">ประวัติ</a> <a class="btn btn-sm btn-danger" href="logout.php">ออก</a></div></div></nav>
<main class="container py-4"><h2>รายการที่กำลังยืม</h2><?php if($msg): ?><div class="alert alert-info"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<div class="card shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>ผู้ยืม</th><th>สมุด</th><th>จำนวน</th><th>วันเวลายืม</th><th>กำหนดคืน</th><th>สถานะ</th><th>จัดการ</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=htmlspecialchars($r['borrower_name'])?></td><td><?=htmlspecialchars($r['book_name'])?></td><td><?= (int)$r['quantity'] ?></td><td><?=htmlspecialchars(Borrowing::formatDate($r['borrowed_at']))?></td><td><?=htmlspecialchars(Borrowing::formatDate($r['due_at']))?></td><td><?=$r['overdue']?'<span class="badge bg-danger">เกินกำหนด</span>':'<span class="badge bg-warning text-dark">กำลังยืม</span>'?></td><td><form method="post" onsubmit="return confirm('ยืนยันการคืนสมุด?')"><input type="hidden" name="id" value="<?=$r['id']?>"><button class="btn btn-sm btn-success">บันทึกคืน</button></form></td></tr><?php endforeach; ?>
<?php if(!$rows): ?><tr><td colspan="7" class="text-center py-4">ไม่มีรายการที่กำลังยืม</td></tr><?php endif; ?></tbody></table></div></div></main></body></html>