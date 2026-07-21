<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>classic coffee</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>" />

  <script>
    window.unggulanProducts = <?= json_encode($produkUnggulan); ?>;
    window.menuKamiProducts = <?= json_encode($menuKami); ?>;
  </script>
  <script defer src="<?= base_url('src/app.js'); ?>"></script>

  <!-- Alpine.js CDN -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <!-- Midtrans Snap SDK Removed -->
</head>

<body>
  <nav class="navbar" x-data>
    <a href="#" class="navbar-logo">classic<span>coffee</span>.</a>

    <div class="navbar-nav">
      <?php foreach ($navLinks as $url => $label): ?>
        <a href="<?= $url; ?>"><?= $label; ?></a>
      <?php endforeach; ?>
    </div>

    <div class="navbar-extra">
      <a href="#" id="search-button"><i data-feather="search"></i></a>
      <a href="#" id="shopping-cart-button">
        <i data-feather="shopping-cart"></i>
        <span class="quantity-badge" x-show="$store.cart.quantity" x-text="$store.cart.quantity"></span>
      </a>
      <button type="button" id="hamburger-menu"
        style="background:none;border:none;cursor:pointer;padding:0;color:inherit;"><i data-feather="menu"></i></button>
    </div>

    <div class="search-form">
      <div style="display: flex; align-items: center; width: 100%; height: 5rem;">
        <input type="search" id="search-box" placeholder="search here..." style="width: 100%; height: 100%; border: none;" />
        <label for="search-box"><i data-feather="search" style="color: var(--bg);"></i></label>
      </div>
      <div class="search-filters" x-data style="display: flex; gap: 8px; width: 100%; padding: 8px 0; justify-content: flex-start; border-top: 1px solid #eee; margin-top: 5px;">
        <span style="color: #666; font-size: 1.2rem; align-self: center; margin-right: 4px;">Filter:</span>
        <button type="button" class="filter-shortcut-btn"
          :class="$store.filter.category === 'Kopi' ? 'active' : ''"
          @click="$store.filter.setCategory('Kopi'); document.getElementById('search-box').value = ''; window.pendingKeyword = ''; resetAllHighlight(); document.getElementById('menu').scrollIntoView({behavior:'smooth'});">Kopi</button>
        <button type="button" class="filter-shortcut-btn"
          :class="$store.filter.category === 'Non-Kopi' ? 'active' : ''"
          @click="$store.filter.setCategory('Non-Kopi'); document.getElementById('search-box').value = ''; window.pendingKeyword = ''; resetAllHighlight(); document.getElementById('menu').scrollIntoView({behavior:'smooth'});">Non-Kopi</button>
        <button type="button" class="filter-shortcut-btn"
          :class="$store.filter.category === 'Pastry' ? 'active' : ''"
          @click="$store.filter.setCategory('Pastry'); document.getElementById('search-box').value = ''; window.pendingKeyword = ''; resetAllHighlight(); document.getElementById('menu').scrollIntoView({behavior:'smooth'});">Pastry</button>
        <button type="button" class="filter-shortcut-btn"
          :class="$store.filter.category === 'Semua' ? 'active' : ''"
          @click="$store.filter.setCategory('Semua'); document.getElementById('search-box').value = ''; window.pendingKeyword = ''; resetAllHighlight();">Semua</button>
      </div>
    </div>
    <div class="shopping-cart">
      <template x-for="(item, index) in $store.cart.items" x-key="index">
        <div class="cart-item">
          <img :src="item.isUnggulan ? getProductImgSrc(item.img) : getMenuImgSrc(item.img, item.img_src)" :alt="item.name" />
          <div class="item-detail">
            <h3 x-text="item.name"></h3>
            <div class="item-price">
              <span x-text="rupiah(item.price)"></span> ×
              <button id="remove" @click="$store.cart.remove(item.id)">−</button>
              <span x-text="item.quantity"></span>
              <button id="add" @click="$store.cart.add(item)">&plus;</button> &equals;
              <span x-text="rupiah(item.total)"></span>
            </div>
          </div>
        </div>
      </template>
      <h4 x-show="!$store.cart.items.length" style="margin-top: 1rem">Cart is Empty</h4>
      <h4 x-show="$store.cart.items.length">Total : <span x-text="rupiah($store.cart.total)"></span></h4>
      <div class="form-container" x-show="$store.cart.items.length">
        <form action="<?= base_url('checkout') ?>" method="POST" id="checkoutForm">
          <input type="hidden" name="items" x-model="JSON.stringify($store.cart.items)" />
          <input type="hidden" name="total" x-model="$store.cart.total" />
          <h5>Customer Detail</h5>
          <label for="name"><span>Name</span><input type="text" name="name" id="name" required/></label>
          <label for="email"><span>Email</span><input type="email" name="email" id="email" required/></label>
          <label for="phone"><span>Phone</span><input type="number" name="phone" id="phone" required
              autocomplete="off" /></label>
          <button class="checkout-button disabled" type="submit" id="checkout-button" value="checkout">Checkout</button>
        </form>
      </div>
    </div>
  </nav>
  <section class="hero" id="home">
    <main class="content">
      <h1>Mari Nikmati Secangkir <span>Kopi</span></h1>
      <p>Kopi yang lezat, momen yang tak terlupakan.</p>
    </main>
  </section>
  <section id="about" class="about">
    <h2><span>Tentang </span>Kami</h2>
    <div class="row">
      <div class="about-img">
        <img src="<?= base_url('img/tentang-kami.jpg') ?>" alt="Tentang Kami" />
      </div>
      <div class="content">
        <h3>Kenapa memilih kopi kami?</h3>
        <p>Dengan pengalaman dan pengetahuan yang luas, kami berkomitmen untuk menyajikan kopi yang lezat dan memuaskan
          bagi Anda.</p>
        <p>Kami tidak hanya menyajikan kopi, kami menyajikan pengalaman yang autentik dan memuaskan, dengan kualitas
          yang tak terkalahkan dan rasa yang tak terlupakan.</p>
      </div>
    </div>
  </section>
  <section id="menu" class="menu" x-data="menu">
    <h2><span>Menu </span>Kami</h2>
    <p>Pilihan kopi terbaik untuk memuaskan selera Anda</p>
    <div class="row">
      <template x-for="(item, index) in items" :key="index">
        <div class="menu-card" style="display: flex; flex-direction: column; align-items: center; justify-content: space-between; padding-bottom: 1.5rem;">
          <img :src="getMenuImgSrc(item.img, item.img_src)" :alt="item.name" class="menu-card-img" @click.prevent="$store.modal.open(item)" style="cursor: pointer;" />
          <h3 class="menu-card-title">- <span x-text="item.name"></span> -</h3>
          <p class="menu-card-price" x-text="'IDR ' + Math.floor(item.price / 1000) + 'K'" style="margin-bottom: 0.5rem;"></p>
          <button @click.prevent="$store.cart.add(item)" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; font-weight: 600; cursor: pointer; border-radius: 8px; border: none; background-color: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; gap: 6px; width: 80%;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="<?= base_url('img/feather-sprite.svg#shopping-cart') ?>" /></svg>
            Beli
          </button>
        </div>
      </template>
    </div>
    <template x-if="totalPages > 1">
      <div class="pagination-container">
        <button @click="prevPage()" :disabled="currentPage === 1" class="page-btn">&laquo;</button>
        <template x-for="page in totalPages" :key="page">
          <button @click="goToPage(page)" :class="currentPage === page ? 'page-btn active' : 'page-btn'" x-text="page"></button>
        </template>
        <button @click="nextPage()" :disabled="currentPage === totalPages" class="page-btn">&raquo;</button>
      </div>
    </template>
  </section>
  <section class="products" id="products" x-data="products">
    <h2><span>Produk</span> Unggulan</h2>
    <p>Kami dengan bangga mempersembahkan produk kopi unggulan kami yang dibuat dengan cinta dan dedikasi. Setiap biji
      kopi dipilih dengan teliti untuk memastikan rasa yang lezat dan memuaskan.</p>
    <div class="row">
      <template x-for="(item, index) in items" :key="index">
        <div class="product-card">
          <div class="product-image">
            <img :src="getProductImgSrc(item.img)" :alt="item.name" />
          </div>
          <div class="product-content">
            <h3 x-text="item.name"></h3>
            <div class="product-price" style="margin-bottom: 0.5rem;"><span x-text="rupiah(item.price)"></span></div>
            <div style="display: flex; gap: 8px; margin-top: 1rem; width: 100%;">
              <button @click.prevent="$store.cart.add(item)" class="btn" style="flex: 1; padding: 0.6rem 1rem; font-size: 0.9rem; font-weight: 600; cursor: pointer; border-radius: 8px; border: none; background-color: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; gap: 6px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="<?= base_url('img/feather-sprite.svg#shopping-cart') ?>" /></svg>
                Beli
              </button>
              <button @click.prevent="$store.modal.open(item)" class="btn" style="flex: 1; padding: 0.6rem 1rem; font-size: 0.9rem; font-weight: 600; cursor: pointer; border-radius: 8px; border: 1px solid var(--primary); background-color: transparent; color: var(--primary); display: flex; align-items: center; justify-content: center; gap: 6px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="<?= base_url('img/feather-sprite.svg#eye') ?>" /></svg>
                Detail
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
    <template x-if="totalPages > 1">
      <div class="pagination-container">
        <button @click="prevPage()" :disabled="currentPage === 1" class="page-btn">&laquo;</button>
        <template x-for="page in totalPages" :key="page">
          <button @click="goToPage(page)" :class="currentPage === page ? 'page-btn active' : 'page-btn'" x-text="page"></button>
        </template>
        <button @click="nextPage()" :disabled="currentPage === totalPages" class="page-btn">&raquo;</button>
      </div>
    </template>
  </section>
  <section id="contact" class="contact">
    <h2><span>Kontak </span>Kami</h2>
    <p>Hubungi kami untuk informasi lebih lanjut atau pertanyaan tentang produk kami.</p>
    <div class="row">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253840.4913165482!2d106.66470409102905!3d-6.229720928612766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1749187568029!5m2!1sid!2sid"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
      <form action="<?= base_url('kontak/kirim') ?>" method="POST">
        <div class="input-group">
          <i data-feather="user"></i>
          <input type="text" name="nama" placeholder="nama" required />
        </div>
        <div class="input-group">
          <i data-feather="mail"></i>
          <input type="email" name="email" placeholder="email" required />
        </div>
        <div class="input-group">
          <i data-feather="bookmark"></i>
          <input type="text" name="subjek" placeholder="subjek" required />
        </div>
        <div class="input-group">
          <i data-feather="message-circle"></i>
          <textarea name="pesan" id="pesan" placeholder="tulis pesan Anda..." rows="4" required></textarea>
        </div>
        <button type="submit" class="btn" id="kontak-submit-btn">kirim pesan</button>
      </form>
    </div>
  </section>

  <!-- Toast Notification untuk Kontak -->
  <div id="contact-toast"></div>

  <footer>
    <div class="social" style="display: flex; justify-content: center; align-items: center; gap: 1.5rem; margin: 1.5rem 0;">
      <a href="https://www.instagram.com/tomorocoffee.id?igsh=MXBxaWxla3lqdm9haQ==" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e7/Instagram_logo_2016.svg" alt="Instagram" style="width: 32px; height: 32px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'" />
      </a>
      <a href="https://www.facebook.com/tomorocoffee.id/" target="_blank" rel="noopener noreferrer">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook" style="width: 32px; height: 32px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'" />
      </a>
      <a href="https://x.com/TomoroCoffee_ID" target="_blank" rel="noopener noreferrer">
        <img src="<?= base_url('img/x_logo.png') ?>" alt="X" style="width: 32px; height: 32px; background: #fff; border-radius: 6px; padding: 4px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'" />
      </a>
    </div>
    <div class="links">
      <?php foreach ($navLinks as $url => $label): ?>
        <a href="<?= $url; ?>"><?= $label; ?></a>
      <?php endforeach; ?>
    </div>
    <div class="credit">
      <p>Created by <a href="">namiraassalwa & zulfarida</a>. | &copy; <?= date('Y'); ?>.</p>
    </div>
  </footer>
  <div class="modal" id="item-detail-modal" x-data :style="$store.modal.show
             ? 'display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);z-index:999999;justify-content:center;align-items:flex-start;overflow-y:auto;'
             : 'display:none;'" x-effect="if ($store.modal.show) { $nextTick(() => feather.replace()); }"
    @click.self="$store.modal.close()">
    <div class="modal-container" @click.stop>
      <button type="button" class="close-icon" @click="$store.modal.close()"><i data-feather="x"></i></button>
      <template x-if="$store.modal.product">
        <div class="modal-content">
          <img :src="$store.modal.product.isUnggulan ? getProductImgSrc($store.modal.product.img) : getMenuImgSrc($store.modal.product.img, $store.modal.product.img_src)" :alt="$store.modal.product.name" />
          <div class="product-content">
            <h3 x-text="$store.modal.product.name"></h3>
            <p x-text="$store.modal.product.desc"
              style="font-size:1.1rem;color:#555;margin:0.5rem 0 1rem;line-height:1.6;"></p>
            <div class="product-price" x-text="rupiah($store.modal.product.price)"></div>
            <button @click.prevent="$store.cart.add($store.modal.product); $store.modal.close()" class="btn" style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 0.8rem; font-size: 1rem; font-weight: 600; cursor: pointer; border-radius: 8px; border: none; background-color: var(--primary); color: #fff;">
              <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><use href="<?= base_url('img/feather-sprite.svg#shopping-cart') ?>" /></svg>
              Tambah ke Keranjang
            </button>
          </div>
        </div>
      </template>
    </div>
  </div>
  <script>
    feather.replace();
    
    function getProductImgSrc(img) {
      if (!img) return '<?= base_url('img/products/1.jpg') ?>';
      if (img.startsWith('http://') || img.startsWith('https://') || img.startsWith('data:') || img.startsWith('/') || img.startsWith('content://')) {
        return img;
      }
      return '<?= base_url('img/products/') ?>' + img;
    }

    function getMenuImgSrc(img, imgSrc) {
      if (imgSrc) return imgSrc;
      if (!img) return '<?= base_url('img/menu/1.jpg') ?>';
      if (img.startsWith('http://') || img.startsWith('https://') || img.startsWith('data:') || img.startsWith('/') || img.startsWith('content://')) {
        return img;
      }
      return '<?= base_url('img/menu/') ?>' + img;
    }
  </script>

  <script src="<?= base_url('js/script.js'); ?>"></script>

  <script>
    // =========================================================
    // CONTACT FORM — AJAX Submit + Toast Notification
    // =========================================================
    (function () {
      var contactForm = document.querySelector('#contact form');
      var toast       = document.getElementById('contact-toast');
      var submitBtn   = document.getElementById('kontak-submit-btn');

      if (!contactForm || !toast) return;

      function showToast(message, type) {
        toast.textContent = message;
        toast.className   = 'show ' + type;   // 'show success' or 'show error'
        // Auto-hide setelah 4 detik
        clearTimeout(toast._timer);
        toast._timer = setTimeout(function () {
          toast.className = '';
        }, 4000);
      }

      contactForm.addEventListener('submit', function (e) {
        e.preventDefault();

        submitBtn.disabled    = true;
        submitBtn.textContent = 'mengirim...';

        var formData = new FormData(contactForm);

        fetch('<?= base_url('kontak/kirim') ?>', {
          method: 'POST',
          body: formData
        })
        .then(function (res) { return res.text(); })
        .then(function (response) {
          var txt = response.trim();
          if (txt.toLowerCase().includes('berhasil')) {
            showToast('Pesan berhasil terkirim! Kami akan segera menghubungi Anda.', 'success');
            contactForm.reset();
          } else {
            showToast('Gagal mengirim pesan: ' + txt, 'error');
          }
        })
        .catch(function () {
          showToast('Terjadi kesalahan koneksi. Silakan coba lagi.', 'error');
        })
        .finally(function () {
          submitBtn.disabled    = false;
          submitBtn.textContent = 'kirim pesan';
        });
      });
    })();
  </script>

  <!-- Midtrans Snap Token Handling -->
  <?php if(isset($snapToken) && $snapToken): ?>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          snap.pay('<?= $snapToken ?>', {
              onSuccess: function(result){
                  window.location.href = "<?= base_url('checkout/success') ?>";
              },
              onPending: function(result){
                  window.location.href = "<?= base_url('checkout/pending') ?>";
              },
              onError: function(result){
                  window.location.href = "<?= base_url('checkout/error') ?>";
              },
              onClose: function(){
                  alert('Anda menutup popup sebelum menyelesaikan pembayaran');
              }
          });
      });
  </script>
  <?php endif; ?>
</body>

</html>
