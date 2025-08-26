<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh">
<div class="container" style="max-width:420px">
  <div class="card shadow-sm">
    <div class="card-body">
      <h1 class="h4 mb-3 text-center">Đăng nhập</h1>
      <?php if (session('error')): ?>
        <div class="alert alert-danger py-2 small mb-3"><?= esc(session('error')) ?></div>
      <?php endif; ?>
      <form method="post" action="/login">
         <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">Tài khoản</label>
          <input name="username" class="form-control" value="<?= esc(old('username')) ?>" autocomplete="username">
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" autocomplete="current-password">
                <button type="button" class="btn btn-outline-secondary" id="togglePass" aria-label="Hiện mật khẩu">Hiện</button>
            </div>
        </div>

        <button class="btn btn-primary w-100">Đăng nhập</button>
      </form>
    </div>
  </div>
</div>
<script>
  (function () {
    const pass = document.getElementById('password');
    const btn  = document.getElementById('togglePass');

    btn.addEventListener('click', function () {
      const show = pass.type === 'password';
      pass.type = show ? 'text' : 'password';
      this.textContent = show ? 'Ẩn' : 'Hiện';
      this.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
    });
  })();
</script>

</body></html>
