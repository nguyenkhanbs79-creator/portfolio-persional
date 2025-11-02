<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

$errors = [];
$title = '';
$slug = '';
$shortDesc = '';
$content = '';
$skills = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!validate_csrf($token)) {
        $errors[] = 'Phiên làm việc không hợp lệ, vui lòng thử lại.';
    }

    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $shortDesc = trim($_POST['short_desc'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $skills = trim($_POST['skills'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if ($title === '') {
        $errors[] = 'Tiêu đề không được để trống.';
    }

    if (!$errors) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare('INSERT INTO projects (title, slug, short_desc, content, skills, image) VALUES (:title, :slug, :short_desc, :content, :skills, :image)');
            $stmt->execute([
                'title' => $title,
                'slug' => $slug ?: null,
                'short_desc' => $shortDesc ?: null,
                'content' => $content ?: null,
                'skills' => $skills ?: null,
                'image' => $image ?: null,
            ]);
            flash('success', 'Tạo dự án thành công.');
            header('Location: /admin/dashboard.php');
            exit;
        } catch (Throwable $e) {
            $errors[] = 'Không thể lưu dự án. Vui lòng thử lại.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Thêm dự án mới</h2>
    <a href="/admin/dashboard.php" class="btn btn-outline-secondary">Quay lại</a>
  </div>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <div><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/admin/projects_create.php">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
    <div class="form-group">
      <label for="title">Tiêu đề</label>
      <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
      <label for="slug">Liên kết / Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>">
      <small class="form-text text-muted">Nhập URL hoặc slug để liên kết tới dự án (tùy chọn).</small>
    </div>
    <div class="form-group">
      <label for="image">Đường dẫn ảnh</label>
      <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" placeholder="uploads/example.jpg hoặc URL">
    </div>
    <div class="form-group">
      <label for="short_desc">Mô tả ngắn</label>
      <textarea class="form-control" id="short_desc" name="short_desc" rows="3"><?php echo htmlspecialchars($shortDesc, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    <div class="form-group">
      <label for="content">Nội dung chi tiết</label>
      <textarea class="form-control" id="content" name="content" rows="5"><?php echo htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    <div class="form-group">
      <label for="skills">Kỹ năng sử dụng</label>
      <textarea class="form-control" id="skills" name="skills" rows="3"><?php echo htmlspecialchars($skills, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Lưu dự án</button>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
