# ระบบยืม-คืนสมุด HTML + PHP OOP

## โครงสร้าง
- `index.html` หน้าแรก
- `borrow.html` ฟอร์มยืมสมุด
- `user_history.html` ฟอร์มดูประวัติ
- `admin_login.html` หน้าเข้าสู่ระบบแอดมิน
- `borrow.php` ประมวลผลการยืม
- `user_history.php` แสดงประวัติ
- `admin_login.php` ตรวจสอบรหัสผ่าน
- `classes/Borrowing.php` คลาส OOP สำหรับจัดการข้อมูลการยืม/คืน
- `config/database.php` จัดการฐานข้อมูล SQLite สำหรับ XAMPP
- `admin/` หน้าจัดการของแอดมิน

## รหัสผ่านแอดมิน
`admin123`

## วิธีรัน XAMPP
1. แตกโฟลเดอร์ `book_borrow_html_oop` ไว้ที่ `C:\xampp\htdocs\`
2. เปิด Apache ใน XAMPP
3. เปิด `http://localhost/book_borrow_html_oop/`
4. ต้องเปิด PDO SQLite ใน PHP ด้วย

## หมายเหตุ
หน้า HTML จะเป็นส่วน View/หน้าจอ ส่วน PHP และคลาส `Borrowing` เป็นส่วนประมวลผลตามแนวคิด OOP/OOAD
