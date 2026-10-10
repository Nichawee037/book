<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/database.php';

class Borrowing
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function borrow(string $borrowerName, string $bookName, int $quantity, string $dueDate, string $dueTime): array
    {
        $borrowerName = trim($borrowerName);
        $bookName = trim($bookName);
        if ($borrowerName === '') return [false, 'กรุณากรอกชื่อผู้ยืม'];
        if ($bookName === '') return [false, 'กรุณากรอกชื่อสมุด'];
        if ($quantity < 1 || $quantity > 100) return [false, 'จำนวนเล่มต้องอยู่ระหว่าง 1-100'];

        $dueTimestamp = strtotime($dueDate . ' ' . $dueTime);
        if ($dueTimestamp === false || $dueTimestamp <= time()) {
            return [false, 'กำหนดคืนต้องเป็นเวลาหลังจากเวลาปัจจุบัน'];
        }

        $stmt = $this->db->prepare(
            'INSERT INTO borrow_records (borrower_name, book_name, quantity, borrowed_at, due_at, status)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $borrowerName, $bookName, $quantity,
            date('Y-m-d H:i:s'), date('Y-m-d H:i:s', $dueTimestamp), 'borrowed'
        ]);
        return [true, 'บันทึกการยืมสมุดเรียบร้อยแล้ว'];
    }

    public function active(): array
    {
        $rows = $this->db->query(
            "SELECT * FROM borrow_records WHERE status='borrowed' ORDER BY due_at ASC"
        )->fetchAll();
        foreach ($rows as &$row) {
            $row['overdue'] = strtotime($row['due_at']) < time();
        }
        return $rows;
    }

    public function history(): array
    {
        return $this->db->query('SELECT * FROM borrow_records ORDER BY id DESC')->fetchAll();
    }

    public function historyByBorrower(string $name): array
    {
        $stmt = $this->db->prepare('SELECT * FROM borrow_records WHERE borrower_name=? ORDER BY id DESC');
        $stmt->execute([trim($name)]);
        return $stmt->fetchAll();
    }

    public function returnBook(int $id): array
    {
        $stmt = $this->db->prepare("SELECT id FROM borrow_records WHERE id=? AND status='borrowed'");
        $stmt->execute([$id]);
        if (!$stmt->fetch()) return [false, 'ไม่พบรายการยืมที่กำลังยืมอยู่'];

        $stmt = $this->db->prepare("UPDATE borrow_records SET returned_at=?, status='returned' WHERE id=?");
        $stmt->execute([date('Y-m-d H:i:s'), $id]);
        return [true, 'บันทึกการคืนสมุดเรียบร้อยแล้ว'];
    }

    public function countActive(): int
    {
        return (int)$this->db->query("SELECT COUNT(*) FROM borrow_records WHERE status='borrowed'")->fetchColumn();
    }

    public function countBorrowedBooks(): int
    {
        return (int)$this->db->query("SELECT COALESCE(SUM(quantity),0) FROM borrow_records WHERE status='borrowed'")->fetchColumn();
    }

    public function countOverdue(): int
    {
        $count = 0;
        foreach ($this->active() as $row) if ($row['overdue']) $count++;
        return $count;
    }

    public static function formatDate(string $value): string
    {
        $time = strtotime($value);
        return $time ? date('d/m/Y H:i', $time) : '-';
    }
}
?>