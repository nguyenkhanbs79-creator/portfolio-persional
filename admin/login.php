<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';

ensure_session_started();

if (is_logged_in()) {
    header('Location: /admin/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!validate_csrf($token)) {
        flash('error', 'Phiên đăng nhập đã hết hạn, vui lòng thử lại.');
        header('Location: /admin/login.php');
        exit;
    }

    if ($username === '' || $password === '') {
        flash('error', 'Vui lòng nhập đủ tên đăng nhập và mật khẩu.');
    } elseif (login($username, $password)) {
        flash('success', 'Đăng nhập thành công.');
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        flash('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title text-center mb-4">Đăng nhập quản trị</h4>
          <form method="POST" action="/admin/login.php">
            <input type="hidden" name="csrf_token"
              value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-group">
              <label for="username">Tên đăng nhập</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Mật khẩu</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary px-4">Đăng nhập</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
