<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash('error', 'Yêu cầu không hợp lệ.');
    header('Location: /admin/dashboard.php');
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (!validate_csrf($token)) {
    flash('error', 'Phiên làm việc không hợp lệ.');
    header('Location: /admin/dashboard.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
if ($id <= 0) {
    flash('error', 'Dự án không hợp lệ.');
    header('Location: /admin/dashboard.php');
    exit;
}

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare('DELETE FROM projects WHERE id = :id');
    $stmt->execute(['id' => $id]);
    flash('success', 'Đã xóa dự án.');
} catch (Throwable $e) {
    flash('error', 'Không thể xóa dự án.');
}

header('Location: /admin/dashboard.php');
exit;
