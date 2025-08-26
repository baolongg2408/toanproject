<!doctype html><html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Bộ ảnh — <?= esc($album['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-3">
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h1 class="h4 mb-0">Bộ ảnh: <?= esc($album['name']) ?></h1>
    <div>
      <a href="/admin/albums" class="btn btn-outline-secondary btn-sm">← Chủ đề</a>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mNew">+ Thêm bộ ảnh</button>
    </div>
  </div>

  <?php if (session('msg')): ?><div class="alert alert-success py-2"><?= esc(session('msg')) ?></div><?php endif; ?>
  <?php if (session('error')): ?><div class="alert alert-danger py-2"><?= esc(session('error')) ?></div><?php endif; ?>

  <div class="table-responsive">
  <table class="table table-sm align-middle">
    <thead><tr><th>#</th><th>Ảnh</th><th>Tên</th><th>Mô tả</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($sets as $s): ?>
      <tr>
        <td><?= $s['id'] ?></td>
        <td style="width:90px">
          <?php if (!empty($s['cover_path'])): ?>
            <img src="/<?= esc($s['cover_path']) ?>" style="height:60px">
          <?php endif; ?>
        </td>
        <td class="fw-semibold"><?= esc($s['name']) ?></td>
        <td><?= esc($s['description']) ?></td>
        <td class="text-end">
          <a class="btn btn-sm btn-success" href="/admin/sets/<?= $s['id'] ?>/photos">Ảnh</a>
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#mEdit<?= $s['id'] ?>">Sửa</button>
          <form action="/admin/sets/<?= $s['id'] ?>/delete" method="post" class="d-inline">
            <?= csrf_field() ?>
            <button class="btn btn-sm btn-danger" onclick="return confirm('Xoá bộ ảnh?')">Xoá</button>
          </form>
        </td>
      </tr>

      <!-- modal sửa -->
      <div class="modal fade" id="mEdit<?= $s['id'] ?>" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
          <form method="post" action="/admin/sets/<?= $s['id'] ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title">Sửa bộ ảnh</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">
              <div class="mb-2"><label class="form-label">Tên</label>
                <input name="name" class="form-control" value="<?= esc($s['name']) ?>">
              </div>
              <div class="mb-2"><label class="form-label">Mô tả</label>
                <textarea name="description" class="form-control"><?= esc($s['description']) ?></textarea>
              </div>
              <div class="mb-2"><label class="form-label">Ảnh đại diện (tuỳ chọn)</label>
                <input type="file" name="cover" class="form-control" accept="image/*">
              </div>
            </div>
            <div class="modal-footer"><button class="btn btn-primary">Lưu</button></div>
          </form>
        </div></div>
      </div>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- modal thêm -->
<div class="modal fade" id="mNew" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" action="/admin/albums/<?= $album['id'] ?>/sets" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-header"><h5 class="modal-title">Thêm bộ ảnh</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
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
      <div class="modal-footer"><button class="btn btn-primary">Tạo</button></div>
    </form>
  </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
