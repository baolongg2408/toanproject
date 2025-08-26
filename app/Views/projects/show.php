<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title><?= esc($project['name']) ?> — ToanDesign</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <style>
    /* phụ trợ gallery */
    .gallery-item img { width:100%; height:100%; object-fit:cover; border-radius:12px; }
    .gallery-item .ratio { background:#f1f3f5; border:1px solid var(--border); border-radius:12px; }
    .meta-chip { display:inline-block; padding:.25rem .5rem; border:1px solid var(--border); border-radius:999px; margin-right:.5rem; color:#495057; background:#fff; }
  </style>
</head>
<body>
<div id="particles-js"></div>
<div class="site-root">

  <!-- AppBar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary appbar fixed-top">
    <div class="container">
       <a class="navbar-brand brand" href="<?= site_url('/') ?>">
      Phạm Đức Toàn <span class="brand-mark">– ToanDesign</span>
    </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Hero của project -->
  <section class="intro-hero fx-gradient mt-2">
    <div id="introParticles"></div>
    <div class="container intro-inner text-center">
      <p class="intro-meta mb-2"><?= esc($project['meta']['location']) ?> — <?= esc($project['meta']['date']) ?></p>
      <h1 class="intro-title fw-bold mb-2"><?= esc($project['name']) ?></h1>
      <p class="mb-0 text-secondary"><?= esc($project['desc']) ?></p>
      <div class="mt-3">
        <span class="meta-chip"><?= esc($project['meta']['category']) ?></span>
        <span class="meta-chip"><?= esc($project['meta']['gear']) ?></span>
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section class="my-4">
    <div class="container">
      <div class="row g-3">
        <?php foreach ($images as $src): ?>
          <div class="col-12 col-sm-6 col-lg-4">
            <div class="gallery-item">
              <a href="#" data-bs-toggle="modal" data-bs-target="#lightbox" data-src="<?= esc($src) ?>">
                <div class="ratio ratio-4x3">
                  <img src="<?= esc($src) ?>" alt="<?= esc($project['name']) ?>" loading="lazy">
                </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Footer (giữ nguyên như trang chủ) -->
  <footer class="site-footer">
    <div class="container py-5 lh-lg">
      <div class="row row-cols-1 row-cols-md-3 g-4 align-items-stretch">
        <div class="col">
          <h4 class="mb-2">Liên hệ</h4>
          <br/>
          <p class="mb-1">Email: <a href="mailto:long.photo@example.com">long.photo@example.com</a></p>
           <br/>
          <p class="mb-0">Zalo/Phone: 09xx xxx xxx</p>
        </div>
        <div class="col">
          <h4 class="mb-2">Mạng xã hội</h4>
           <br/>
          <p class="mb-0"><a href="#" target="_blank">Instagram @long.shoots</a></p>
        </div>
        <div class="col d-flex flex-column justify-content-end align-items-end text-end">
          <div class="copy">© <span id="year"></span> Long Photo</div>
        </div>
      </div>
    </div>
  </footer>
</div>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightbox" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-dark border-0">
      <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <img id="lightboxImg" src="" alt="" class="w-100" style="max-height:80vh; object-fit:contain;">
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/particles.min.js') ?>"></script>
<script>
  particlesJS.load('particles-js', '<?= base_url('assets/js/particles.intro.json') ?>');
  particlesJS.load('introParticles', '<?= base_url('assets/js/intro_particles.intro.json') ?>');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Lightbox: gán src cho ảnh lớn khi click
  const lightbox = document.getElementById('lightbox');
  lightbox.addEventListener('show.bs.modal', function (e) {
    const trigger = e.relatedTarget;
    const src = trigger?.getAttribute('data-src');
    if (src) document.getElementById('lightboxImg').src = src;
  });
  // Năm footer
  document.getElementById('year').textContent = new Date().getFullYear();
</script>
</body>
</html>
