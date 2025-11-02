<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    flash('error', 'Dự án không tồn tại.');
    header('Location: /admin/dashboard.php');
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare('SELECT * FROM projects WHERE id = :id');
$stmt->execute(['id' => $id]);
$project = $stmt->fetch();

if (!$project) {
    flash('error', 'Không tìm thấy dự án.');
    header('Location: /admin/dashboard.php');
    exit;
}

$errors = [];
$title = $project['title'] ?? '';
$slug = $project['slug'] ?? '';
$shortDesc = $project['short_desc'] ?? '';
$content = $project['content'] ?? '';
$skills = $project['skills'] ?? '';
$image = $project['image'] ?? '';

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
            $update = $pdo->prepare('UPDATE projects SET title = :title, slug = :slug, short_desc = :short_desc, content = :content, skills = :skills, image = :image WHERE id = :id');
            $update->execute([
                'title' => $title,
                'slug' => $slug ?: null,
                'short_desc' => $shortDesc ?: null,
                'content' => $content ?: null,
                'skills' => $skills ?: null,
                'image' => $image ?: null,
                'id' => $id,
            ]);
            flash('success', 'Cập nhật dự án thành công.');
            header('Location: /admin/dashboard.php');
            exit;
        } catch (Throwable $e) {
            $errors[] = 'Không thể cập nhật dự án. Vui lòng thử lại.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Chỉnh sửa dự án</h2>
    <div>
      <a href="/admin/dashboard.php" class="btn btn-outline-secondary mr-2">Quay lại</a>
      <form method="POST" action="/admin/projects_delete.php" class="d-inline">
        <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa dự án này?');">Xóa</button>
      </form>
    </div>
  </div>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <div><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="POST" action="/admin/projects_edit.php?id=<?php echo (int) $id; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
    <div class="form-group">
      <label for="title">Tiêu đề</label>
      <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
      <label for="slug">Liên kết / Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($slug, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="form-group">
      <label for="image">Đường dẫn ảnh</label>
      <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>">
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
    <button type="submit" class="btn btn-primary">Cập nhật</button>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
