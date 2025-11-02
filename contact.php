<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /index.php#contact');
    exit;
}

ensure_session_started();

$token = $_POST['csrf_token'] ?? '';
if (!validate_csrf($token)) {
    flash('error', 'Phiên làm việc không hợp lệ, vui lòng thử lại.');
    header('Location: /index.php#contact');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];

if ($name === '') {
    $errors[] = 'Vui lòng nhập họ tên.';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ.';
}

if ($message === '') {
    $errors[] = 'Vui lòng nhập nội dung tin nhắn.';
}

if ($errors) {
    flash('error', implode(' ', $errors));
    header('Location: /index.php#contact');
    exit;
}

try {
    $pdo = getPDO();
    $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)');
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'message' => $message,
    ]);
    flash('success', 'Gửi thành công. Cảm ơn bạn đã liên hệ!');
} catch (Throwable $e) {
    flash('error', 'Không thể lưu tin nhắn của bạn lúc này. Vui lòng thử lại sau.');
}

header('Location: /index.php#contact');
exit;
