<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Profile — Photo Portfolio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=2') ?>">
</head>
<body>
    <!-- nền particles -->
<div id="particles-js"></div>
<!-- nội dung trang -->
<div class="site-root">
  <!-- AppBar -->
  
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary sticky-top">
  <div class="container">
    <a class="navbar-brand brand" href="<?= base_url('/') ?>">
      Phạm Đức Toàn <span class="brand-mark">– ToanDesign</span>
    </a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <!-- ms-auto: đẩy menu sang phải (bỏ nếu muốn trái) -->
        <ul class="navbar-nav ms-auto gap-lg-2">
        <?php foreach ($topics as $t): 
                $slug = url_title($t, '-', true);
                 // Lấy segment 2, nếu không có thì trả về ''
                 $uri = service('uri');
                    $seg2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
                $isActive = ($seg2 === $slug);
        ?>
            <li class="nav-item">
            <a class="nav-link <?= $isActive ? 'active' : '' ?>"
                href="<?= site_url('topic/'.$slug) ?>#projects"
                data-topic="<?= esc($t) ?>"
                data-bs-toggle="collapse"          
                data-bs-target="#mainNav"           
                >
                <?= esc($t) ?>
            </a>
            </li>
        <?php endforeach; ?>
        </ul>
        <div class="ms-lg-3 mt-2 mt-lg-0">
          <a href="<?= site_url('login') ?>"
            class="btn btn-outline-dark btn-sm">
            <i class="fa-solid fa-user-shield me-1"></i> Admin
          </a>
        </div>

    </div>
  </div>
</nav>
<!-- Intro block -->
 <section class="intro-hero fx-gradient mt-2">
      <!-- Nền particles riêng cho intro -->
  <div id="introParticles"></div>
  <div class="container text-center intro-inner">
    <p class="intro-meta mb-3">TP Hồ Chí Minh - <?= date('M j, Y') ?></p>
    <h1 class="intro-title fw-bold mb-3">ToanDesign</h1>
    <p class="intro-name fw-semibold">Mang đến cho bạn sự hài lòng</p>
  </div>
</section>

  <!-- Slider “quảng cáo” các poster nhỏ (tự chạy) -->
<section class="carousel-wrap py-2">
  <div class="container">
    <div class="row g-0"><div class="col-12">
      <div class="border-frame rounded-4">
        <div class="frame-inner py-3">
          <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-4">
              <div id="carouselExampleSlidesOnly"
                   class="carousel slide hero-carousel mx-auto"
                   data-bs-ride="carousel" data-bs-interval="2000">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="<?= base_url('assets/images/mini1.jpg')?>" class="d-block w-100" alt="">
                  </div>
                  <div class="carousel-item">
                    <img src="<?= base_url('assets/images/mini2.jpg')?>" class="d-block w-100" alt="">
                  </div>
                  <div class="carousel-item">
                    <img src="<?= base_url('assets/images/mini3.jpg')?>" class="d-block w-100" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div><!-- /row -->
        </div>
      </div>
    </div></div>
  </div>
</section>

  <!-- Dự án nổi bật -->
   <section id="projects" class="featured my-4">
  <div class="container">
    <h2 id="projectsTitle" class="section-title">Dự án nổi bật</h2>
    <div class="row g-3" id="projectsGrid">
      <?php foreach ($featured as $f):
  $slug = $f['slug'] ?? url_title($f['name'], '-', true);
?>
  <div class="col-12 col-sm-6 col-lg-3">
    <article class="card h-100 position-relative">
      <img src="<?= esc($f['cover']) ?>" class="card-img-top" alt="<?= esc($f['name']) ?>">
      <div class="card-body">
        <h3 class="h6 mb-1"><?= esc($f['name']) ?></h3>
        <p class="mb-0 text-secondary"><?= esc($f['desc']) ?></p>
      </div>
      <a class="stretched-link" href="<?= site_url('project/'.$slug) ?>"></a>
    </article>
  </div>
<?php endforeach; ?>

    </div>
  </div>
</section>
<!-- Footer -->
 <footer class="site-footer">
  <div class="container py-5">
    <!-- 3 cột bằng nhau từ md trở lên, cao bằng nhau -->
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

      <!-- Cột phải: đẩy nội dung xuống đáy và căn phải -->
      <div class="col d-flex flex-column justify-content-end align-items-end text-end">
        <div class="copy">© <span id="year"></span> Long Photo</div>
      </div>
    </div>
  </div>
</footer>

</div>

<script src="<?= base_url('assets/js/particles.min.js') ?>"></script>
<script>
  particlesJS.load(
    'particles-js',
    '<?= base_url('assets/js/particles.intro.json') ?>',
    function(){ /* loaded */ }
  );
</script>
<script>
  particlesJS.load(
    'introParticles',
    '<?= base_url('assets/js/intro_particles.intro.json') ?>',
    function(){ /* loaded */ }
  );
</script>
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
