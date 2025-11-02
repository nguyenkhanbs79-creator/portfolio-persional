<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';

logout();
flash('success', 'Bạn đã đăng xuất.');
header('Location: /admin/login.php');
exit;
