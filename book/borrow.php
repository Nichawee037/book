<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/classes/Borrowing.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: borrow.html');
    exit;
}

$borrowerName = $_POST['borrower_name'] ?? '';
$bookName = $_POST['book_name'] ?? '';
$quantity = (int)($_POST['quantity'] ?? 0);
$dueDate = $_POST['due_date'] ?? '';
$dueTime = $_POST['due_time'] ?? '';

try {
    $result = (new Borrowing())->borrow($borrowerName, $bookName, $quantity, $dueDate, $dueTime);
} catch (Throwable $e) {
    $result = [false, 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาตรวจสอบฐานข้อมูล'];
}
$_SESSION['message'] = $result[1];
$_SESSION['message_type'] = $result[0] ? 'success' : 'danger';
header('Location: borrow.html');
exit;
?>