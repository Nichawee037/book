<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php'; requireAdmin();
require_once __DIR__ . '/../classes/Borrowing.php';
$b = new Borrowing();
?><!doctype html><html lang="th"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Dashboard</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../assets/style.css"></head>
<body><nav class="navbar navbar-dark bg-dark"><div class="container"><a class="navbar-brand" href="index.php">⚙️ แอดมิน</a><div><a class="btn btn-sm btn-outline-light" href="active.php">รายการยืม</a> <a class="btn btn-sm btn-outline-light" href="history.php">ประวัติ</a> <a class="btn btn-sm btn-danger" href="logout.php">ออก</a></div></div></nav>
<main class="container py-4"><section class="hero dark"><h1>Admin Dashboard</h1><p>จัดการรายการยืมและคืนสมุด</p></section>
<div class="row g-3 mt-2"><div class="col-md-4"><div class="card p-4 shadow-sm"><small>รายการกำลังยืม</small><strong class="display-6"><?= $b->countActive() ?></strong></div></div>
<div class="col-md-4"><div class="card p-4 shadow-sm"><small>จำนวนสมุดที่ยืม</small><strong class="display-6"><?= $b->countBorrowedBooks() ?></strong></div></div>
<div class="col-md-4"><div class="card p-4 shadow-sm"><small>เกินกำหนด</small><strong class="display-6 text-danger"><?= $b->countOverdue() ?></strong></div></div></div>
<div class="mt-4"><a class="btn btn-primary" href="active.php">ดูรายการที่กำลังยืม</a> <a class="btn btn-outline-dark" href="history.php">ดูประวัติ</a></div></main></body></html>