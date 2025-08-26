<!doctype html><html lang="vi"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ảnh — <?= esc($set['name']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-3">
<div class="container">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <h1 class="h4 mb-0">Ảnh: <?= esc($set['name']) ?></h1>
    <div>
      <a href="/admin/albums/<?= $set['album_id'] ?>/sets" class="btn btn-outline-secondary btn-sm">← Bộ ảnh</a>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mUpload">+ Upload ảnh</button>
    </div>
  </div>

  <?php if (session('msg')): ?><div class="alert alert-success py-2"><?= esc(session('msg')) ?></div><?php endif; ?>
  <?php if (session('error')): ?><div class="alert alert-danger py-2"><?= esc(session('error')) ?></div><?php endif; ?>

  <div class="row g-3">
  <?php foreach ($photos as $p): ?>
    <div class="col-6 col-md-3">
      <div class="card h-100">
        <img src="/<?= esc($p['thumb_path']) ?>" class="card-img-top" alt="">
        <div class="card-body p-2">
          <div class="small fw-semibold text-truncate" title="<?= esc($p['title']) ?>"><?= esc($p['title']) ?></div>
          <div class="d-flex gap-1 mt-2">
            <button class="btn btn-warning btn-sm flex-grow-1" data-bs-toggle="modal" data-bs-target="#mEdit<?= $p['id'] ?>">Sửa</button>
            <form action="/admin/photos/<?= $p['id'] ?>/delete" method="post">
              <?= csrf_field() ?>
              <button class="btn btn-danger btn-sm" onclick="return confirm('Xoá ảnh?')">Xoá</button>
            </form>
          </div>
          <form class="mt-2" method="post" action="/admin/sets/<?= $set['id'] ?>/cover/<?= $p['id'] ?>">
            <?= csrf_field() ?>
            <button class="btn btn-outline-secondary btn-sm w-100">Đặt làm ảnh đại diện bộ</button>
          </form>
        </div>
      </div>
    </div>

    <!-- modal edit -->
    <div class="modal fade" id="mEdit<?= $p['id'] ?>" tabindex="-1">
      <div class="modal-dialog"><div class="modal-content">
        <form method="post" action="/admin/photos/<?= $p['id'] ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="set_id" value="<?= $set['id'] ?>">
          <div class="modal-header"><h5 class="modal-title">Sửa ảnh</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
          <div class="modal-body">
            <div class="mb-2"><label class="form-label">Tiêu đề</label>
              <input name="title" class="form-control" value="<?= esc($p['title']) ?>">
            </div>
            <div class="mb-2"><label class="form-label">Chú thích</label>
              <textarea name="caption" class="form-control"><?= esc($p['caption']) ?></textarea>
            </div>
          </div>
          <div class="modal-footer"><button class="btn btn-primary">Lưu</button></div>
        </form>
      </div></div>
    </div>
  <?php endforeach; ?>
  </div>
</div>

<!-- modal upload -->
<div class="modal fade" id="mUpload" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post" enctype="multipart/form-data"
      action="<?= site_url('admin/sets/'.$set['id'].'/photos/create') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="set_id" value="<?= esc($set['id']) ?>">
      <div class="modal-header"><h5 class="modal-title">Upload nhiều ảnh</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <input type="file" name="files[]" class="form-control" accept="image/*" multiple required>
      </div>
      <div class="modal-footer"><button class="btn btn-primary">Tải lên</button></div>
    </form>
  </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
