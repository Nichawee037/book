<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

function requireAdmin(): void
{
    if (empty($_SESSION['admin_logged_in'])) {
        header('Location: ../admin_login.html');
        exit;
    }
}
?>