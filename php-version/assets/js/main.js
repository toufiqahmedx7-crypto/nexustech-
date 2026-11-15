/* NexusTech — front-end interactions (vanilla JS, no dependencies) */
(function () {
  'use strict';

  /* ---------- Page fade-in ---------- */
  requestAnimationFrame(function () {
    document.body.classList.add('page-ready');
  });

  /* ---------- Navbar scroll state ---------- */
  var navbar = document.getElementById('navbar');
  function onScroll() {
    if (window.scrollY > 24) navbar.classList.add('is-scrolled');
    else navbar.classList.remove('is-scrolled');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Hamburger ---------- */
  var hamburger = document.getElementById('hamburger');
  var mobileMenu = document.getElementById('mobile-menu');
  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', function () {
      var open = mobileMenu.classList.toggle('open');
      hamburger.classList.toggle('open', open);
      hamburger.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* ---------- Reveal on scroll ---------- */
  var observer = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { rootMargin: '-60px 0px' });
  document.querySelectorAll('.reveal').forEach(function (el) {
    observer.observe(el);
  });

  /* ---------- Hero slider ---------- */
  var hero = document.getElementById('hero');
  if (hero) {
    var slides = hero.querySelectorAll('.hero-slide');
    var dots = document.getElementById('hero-dots');
    var current = 0;
    var timer = null;
    var AUTOPLAY = 6000;

    function show(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach(function (s, i) {
        s.classList.toggle('active', i === current);
      });
      if (dots) {
        dots.querySelectorAll('.hero-dot').forEach(function (d, i) {
          d.classList.toggle('active', i === current);
        });
      }
    }

    function play() {
      stop();
      timer = setInterval(function () { show(current + 1); }, AUTOPLAY);
    }
    function stop() {
      if (timer) clearInterval(timer);
    }

    var prev = document.getElementById('hero-prev');
    var next = document.getElementById('hero-next');
    if (prev) prev.addEventListener('click', function () { show(current - 1); play(); });
    if (next) next.addEventListener('click', function () { show(current + 1); play(); });
    if (dots) {
      dots.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-goto]');
        if (btn) { show(parseInt(btn.dataset.goto, 10)); play(); }
      });
    }
    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', play);
    play();
  }

  /* ---------- Product gallery ---------- */
  var thumbs = document.getElementById('gallery-thumbs');
  var mainImg = document.getElementById('gallery-main-img');
  if (thumbs && mainImg) {
    thumbs.addEventListener('click', function (e) {
      var btn = e.target.closest('.gallery-thumb');
      if (!btn) return;
      thumbs.querySelectorAll('.gallery-thumb').forEach(function (t) {
        t.classList.toggle('active', t === btn);
      });
      mainImg.style.opacity = '0';
      setTimeout(function () {
        mainImg.src = btn.dataset.src;
        mainImg.style.opacity = '1';
      }, 160);
    });
  }

  /* ---------- Detail page: quantity + color ---------- */
  var qtyValue = document.getElementById('qty-value');
  var qtyMinus = document.getElementById('qty-minus');
  var qtyPlus = document.getElementById('qty-plus');
  var detailAdd = document.getElementById('detail-add');
  var detailQty = 1;
  var detailColor = 0;

  function syncDetailAdd() {
    if (!detailAdd) return;
    detailAdd.dataset.qty = String(detailQty);
    detailAdd.dataset.color = String(detailColor);
  }
  if (qtyMinus && qtyPlus && qtyValue) {
    qtyMinus.addEventListener('click', function () {
      detailQty = Math.max(1, detailQty - 1);
      qtyValue.textContent = detailQty;
      syncDetailAdd();
    });
    qtyPlus.addEventListener('click', function () {
      detailQty = Math.min(99, detailQty + 1);
      qtyValue.textContent = detailQty;
      syncDetailAdd();
    });
  }
  var colorRow = document.getElementById('color-row');
  if (colorRow) {
    colorRow.addEventListener('click', function (e) {
      var swatch = e.target.closest('.color-swatch');
      if (!swatch) return;
      colorRow.querySelectorAll('.color-swatch').forEach(function (s) {
        var active = s === swatch;
        s.classList.toggle('active', active);
        s.setAttribute('aria-pressed', active ? 'true' : 'false');
      });
      detailColor = parseInt(swatch.dataset.color, 10) || 0;
      syncDetailAdd();
    });
  }

  /* ---------- Cart ---------- */
  var overlay = document.getElementById('cart-overlay');
  var drawer = document.getElementById('mini-cart');
  var badge = document.getElementById('cart-badge');
  var body = document.getElementById('cart-body');
  var foot = document.getElementById('cart-foot');
  var totalEl = document.getElementById('cart-total');
  var pill = document.getElementById('cart-pill');

  function money(n) {
    return '$' + Number(n).toLocaleString('en-US', { maximumFractionDigits: 0 });
  }

  function openCart() {
    overlay.hidden = false;
    drawer.hidden = false;
    requestAnimationFrame(function () {
      overlay.classList.add('show');
      drawer.classList.add('show');
    });
  }
  function closeCart() {
    overlay.classList.remove('show');
    drawer.classList.remove('show');
    setTimeout(function () {
      overlay.hidden = true;
      drawer.hidden = true;
    }, 300);
  }

  var openBtn = document.getElementById('cart-open');
  var closeBtn = document.getElementById('cart-close');
  if (openBtn) openBtn.addEventListener('click', openCart);
  if (closeBtn) closeBtn.addEventListener('click', closeCart);
  if (overlay) overlay.addEventListener('click', closeCart);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeCart();
  });

  function renderCart(data) {
    if (badge) {
      badge.dataset.count = data.count;
      badge.textContent = data.count;
      badge.hidden = data.count === 0;
      badge.classList.remove('bump');
      if (data.count > 0) {
        void badge.offsetWidth;
        badge.classList.add('bump');
      }
    }
    if (pill) pill.textContent = data.count;

    if (!body) return;
    body.innerHTML = '';
    if (data.items.length === 0) {
      body.innerHTML =
        '<div class="cart-empty">' +
        '<div class="cart-empty-icon">🛒</div>' +
        '<p>Your cart is empty.</p>' +
        '<a href="products.php" class="btn btn-ghost" id="cart-browse">Browse products</a>' +
        '</div>';
      var browse = document.getElementById('cart-browse');
      if (browse) browse.addEventListener('click', closeCart);
    } else {
      data.items.forEach(function (item) {
        var row = document.createElement('div');
        row.className = 'cart-item';
        row.innerHTML =
          '<a href="product.php?slug=' + encodeURIComponent(item.slug) + '" class="cart-item-img">' +
          '<img src="' + item.image + '" alt=""></a>' +
          '<div class="cart-item-info">' +
          '<a href="product.php?slug=' + encodeURIComponent(item.slug) + '" class="cart-item-name"></a>' +
          '<span class="cart-item-price">' + money(item.price) + '</span>' +
          '<div class="qty-stepper small">' +
          '<button type="button" data-dec="' + item.key + '" aria-label="Decrease quantity">−</button>' +
          '<span>' + item.qty + '</span>' +
          '<button type="button" data-inc="' + item.key + '" aria-label="Increase quantity">+</button>' +
          '</div></div>' +
          '<button class="icon-button remove" data-remove="' + item.key + '" aria-label="Remove item">' +
          '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">' +
          '<path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg></button>';
        row.querySelector('.cart-item-name').textContent = item.name;
        body.appendChild(row);
      });
    }

    if (foot) foot.hidden = data.items.length === 0;
    if (totalEl) totalEl.textContent = money(data.total);
  }

  function post(action, fields) {
    var form = new FormData();
    form.append('action', action);
    Object.keys(fields || {}).forEach(function (k) {
      form.append(k, fields[k]);
    });
    return fetch('cart-api.php', { method: 'POST', body: form, credentials: 'same-origin' })
      .then(function (r) { return r.json(); });
  }

  function refresh() {
    post('list').then(renderCart);
  }

  if (body) {
    body.addEventListener('click', function (e) {
      var dec = e.target.closest('[data-dec]');
      var inc = e.target.closest('[data-inc]');
      var rem = e.target.closest('[data-remove]');
      if (dec) {
        var span = dec.closest('.cart-item').querySelector('.qty-stepper span');
        post('update', { key: dec.dataset.dec, qty: parseInt(span.textContent, 10) - 1 }).then(renderCart);
      } else if (inc) {
        var span2 = inc.closest('.cart-item').querySelector('.qty-stepper span');
        post('update', { key: inc.dataset.inc, qty: parseInt(span2.textContent, 10) + 1 }).then(renderCart);
      } else if (rem) {
        post('remove', { key: rem.dataset.remove }).then(renderCart);
      }
    });
  }

  /* ---------- Add to cart buttons ---------- */
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.add-to-cart');
    if (!btn || btn.disabled) return;
    post('add', { id: btn.dataset.id, qty: btn.dataset.qty || 1, color: btn.dataset.color || 0 })
      .then(function (data) {
        renderCart(data);
        openCart();
        btn.classList.add('flash');
        setTimeout(function () { btn.classList.remove('flash'); }, 600);
      });
  });

  /* ---------- Newsletter ---------- */
  var newsletter = document.getElementById('newsletter-form');
  if (newsletter) {
    newsletter.addEventListener('submit', function (e) {
      e.preventDefault();
      var btn = newsletter.querySelector('button');
      btn.textContent = '✓ Joined';
      newsletter.querySelector('input').value = '';
      setTimeout(function () { btn.textContent = 'Join'; }, 3200);
    });
  }

  refresh();
})();
