<?php
declare(strict_types=1);

class Database
{
    private string $dbFile;

    public function __construct()
    {
        $dir = __DIR__ . '/../database';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->dbFile = $dir . '/library.sqlite';
    }

    public function connect(): PDO
    {
        if (!extension_loaded('pdo_sqlite')) {
            throw new RuntimeException('เซิร์ฟเวอร์ยังไม่ได้เปิด PDO SQLite');
        }

        $pdo = new PDO('sqlite:' . $this->dbFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $pdo->exec("CREATE TABLE IF NOT EXISTS borrow_records (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            borrower_name TEXT NOT NULL,
            book_name TEXT NOT NULL,
            quantity INTEGER NOT NULL DEFAULT 1,
            borrowed_at TEXT NOT NULL,
            due_at TEXT NOT NULL,
            returned_at TEXT DEFAULT NULL,
            status TEXT NOT NULL DEFAULT 'borrowed'
        )");

        return $pdo;
    }
}
?>