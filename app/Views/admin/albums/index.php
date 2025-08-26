<!doctype html><html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Quản lý Chủ đề</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-3">
<div class="container">
  <h1 class="h3 mb-3">Chủ đề (Albums)</h1>

  <?php if (session('msg')): ?><div class="alert alert-success py-2"><?= esc(session('msg')) ?></div><?php endif; ?>
  <?php if (session('error')): ?><div class="alert alert-danger py-2"><?= esc(session('error')) ?></div><?php endif; ?>

  <div class="mb-2">
    <a href="/logout" class="btn btn-outline-secondary btn-sm">Đăng xuất</a>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNew">+ Thêm chủ đề</button>
  </div>

  <div class="table-responsive">
  <table class="table table-sm align-middle">
    <thead><tr><th>#</th><th>Ảnh</th><th>Tên</th><th>Mô tả</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($albums as $a): ?>
      <tr>
        <td><?= $a['id'] ?></td>
        <td style="width:90px">
          <?php if (!empty($a['cover_path'])): ?>
            <img src="/<?= esc($a['cover_path']) ?>" style="height:60px">
          <?php endif; ?>
        </td>
        <td class="fw-semibold"><?= esc($a['name']) ?></td>
        <td><?= esc($a['description']) ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-success" href="/admin/albums/<?= $a['id'] ?>/sets">Thêm bộ ảnh</a>
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#mEdit<?= $a['id'] ?>">Sửa</button>
          <form action="/admin/albums/<?= $a['id'] ?>/delete" method="post" class="d-inline">
            <?= csrf_field() ?>
            <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá chủ đề?')">Xoá</button>
          </form>
        </td>
      </tr>

      <!-- Modal sửa -->
      <div class="modal fade" id="mEdit<?= $a['id'] ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
          <form method="post" action="/admin/albums/<?= $a['id'] ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title">Sửa chủ đề</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">
              <div class="mb-2"><label class="form-label">Tên</label>
                <input name="name" class="form-control" value="<?= esc($a['name']) ?>">
              </div>
              <div class="mb-2"><label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control"><?= esc($a['description']) ?></textarea>
              </div>
              <div class="mb-2"><label class="form-label">Ảnh đại diện (tuỳ chọn)</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary">Lưu</button>
            </div>
          </form>
        </div></div>
      </div>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Modal thêm -->
<div class="modal fade" id="modalNew" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" action="/admin/albums" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-header"><h5 class="modal-title">Thêm chủ đề</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <div class="mb-2"><label class="form-label">Tên</label>
          <input name="name" class="form-control" required>
        </div>
        <div class="mb-2"><label class="form-label">Mô tả</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-2"><label class="form-label">Ảnh đại diện (tuỳ chọn)</label>
          <input type="file" name="cover" class="form-control" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Tạo</button>
      </div>
    </form>
  </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
