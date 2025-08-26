// Year
document.getElementById('year') && (document.getElementById('year').textContent = new Date().getFullYear());

// Toggle topic bar + icon animation
const btnTopics = document.getElementById('btnTopics');
const topicBar  = document.getElementById('topicBar');
const menuIcon  = document.getElementById('menuIcon');

if (btnTopics && topicBar && menuIcon) {
  btnTopics.addEventListener('click', () => {
    topicBar.classList.toggle('open');
    const opened = topicBar.classList.contains('open');
    btnTopics.setAttribute('aria-expanded', opened ? 'true' : 'false');
    menuIcon.className = opened ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
  });
}


// Mini slider (auto-scroll loop)
const track = document.getElementById('sliderTrack');
if (track) {
  let x = 0;
  const speed = 0.5; // px/frame
  function tick() {
    x -= speed;
    // Khi trượt quá nửa (vì đã nhân đôi slides), reset để tạo vòng lặp mượt
    const width = track.scrollWidth / 2;
    if (Math.abs(x) >= width + 10) x = 0;
    track.style.transform = `translateX(${x}px)`;
    requestAnimationFrame(tick);
  }
  requestAnimationFrame(tick);
}
// Cuộn khi click Item
(function () {
  const navLinks   = document.querySelectorAll('.navbar .nav-link[data-topic]');
  const projects   = document.getElementById('projects');
  const titleEl    = document.getElementById('projectsTitle');
  const header     = document.querySelector('.appbar');
  const offset     = (header?.offsetHeight || 0) + 8; // trừ chiều cao navbar

  function smoothTo(el){
    const y = el.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top: y, behavior: 'smooth' });
  }

  navLinks.forEach(a => {
    a.addEventListener('click', (e) => {
      e.preventDefault();

      // 1) Đổi tiêu đề theo text được click
      const label = (a.dataset.topic || a.textContent).trim();
      titleEl.textContent = label;

      // 2) Active state cho menu
      document.querySelectorAll('.navbar .nav-link.active').forEach(x => x.classList.remove('active'));
      a.classList.add('active');

      // 3) Cuộn mượt tới khu dự án
      smoothTo(projects);

      // 4) Cập nhật URL (không reload) để share/back-forward vẫn đúng
      //    Lấy path từ href của link (đã có #projects)
      const url = new URL(a.getAttribute('href'), window.location.origin);
      history.pushState({ topic: label }, '', url.pathname + url.hash);

      // 5) TODO: Lọc/Load dữ liệu theo chủ đề (để sau)
      // fetch(`/api/projects?topic=${encodeURIComponent(slug)}`).then(...render...)
    });
  });

  // Khi bấm Back/Forward, khôi phục tiêu đề (phần data sẽ làm sau)
  window.addEventListener('popstate', (ev) => {
    if (ev.state?.topic) titleEl.textContent = ev.state.topic;
  });
})();
