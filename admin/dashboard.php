<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

$pdo = getPDO();
$projectCount = (int) $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();
$messageCount = (int) $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$recentMessages = $pdo->query('SELECT name, email, created_at FROM messages ORDER BY created_at DESC LIMIT 5')->fetchAll();
$recentProjects = $pdo->query('SELECT id, title, created_at FROM projects ORDER BY created_at DESC LIMIT 5')->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Bảng điều khiển</h2>
    <a href="/admin/logout.php" class="btn btn-outline-secondary">Đăng xuất</a>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card text-white bg-primary">
        <div class="card-body">
          <h5 class="card-title">Tổng số dự án</h5>
          <p class="card-text display-4"><?php echo $projectCount; ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card text-white bg-success">
        <div class="card-body">
          <h5 class="card-title">Tin nhắn nhận được</h5>
          <p class="card-text display-4"><?php echo $messageCount; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Dự án mới nhất</span>
          <a href="/admin/projects_create.php" class="btn btn-sm btn-primary">Thêm dự án</a>
        </div>
        <ul class="list-group list-group-flush">
          <?php if ($recentProjects): ?>
            <?php foreach ($recentProjects as $project): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?php echo htmlspecialchars($project['title'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span>
                  <a href="/admin/projects_edit.php?id=<?php echo (int) $project['id']; ?>" class="btn btn-sm btn-outline-secondary">Sửa</a>
                </span>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item">Chưa có dự án nào.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-header">Tin nhắn gần đây</div>
        <ul class="list-group list-group-flush">
          <?php if ($recentMessages): ?>
            <?php foreach ($recentMessages as $message): ?>
              <li class="list-group-item">
                <strong><?php echo htmlspecialchars($message['name'], ENT_QUOTES, 'UTF-8'); ?></strong>
                <div class="small text-muted"><?php echo htmlspecialchars($message['email'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo htmlspecialchars($message['created_at'], ENT_QUOTES, 'UTF-8'); ?></div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item">Chưa có tin nhắn nào.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
