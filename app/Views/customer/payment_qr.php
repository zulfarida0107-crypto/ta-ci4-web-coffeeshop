<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran — Classic Coffee</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- QR Code Library (qrcode.js via CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        :root {
            --primary:   #6b3a2a;
            --accent:    #b6895b;
            --light-bg:  #faf6f0;
            --card-bg:   #ffffff;
            --text:      #2d1a0e;
            --muted:     #7a6655;
            --success:   #2e7d32;
            --border:    #e8ddd5;
            --radius:    14px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 2rem 1rem 4rem;
        }

        /* ── Header ── */
        .page-header {
            text-align: center;
            margin-bottom: 1.8rem;
        }
        .page-header .logo {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        .page-header .logo span { color: var(--accent); }
        .page-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            margin-top: 0.4rem;
        }
        .page-header p {
            font-size: 0.88rem;
            color: var(--muted);
            margin-top: 0.25rem;
        }

        /* ── Main Layout ── */
        .payment-wrapper {
            width: 100%;
            max-width: 780px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 620px) {
            .payment-wrapper { grid-template-columns: 1fr; }
        }

        /* ── Card ── */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .card-title {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--accent);
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            border-bottom: 1px solid var(--border);
        }

        /* ── QR Section ── */
        .qr-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        #qrcode {
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #qrcode canvas, #qrcode img {
            border: 6px solid var(--light-bg);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(107,58,42,0.15);
        }
        .qr-hint {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 0.75rem;
            line-height: 1.6;
        }
        .qr-scan-label {
            background: var(--light-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.82rem;
            color: var(--primary);
            font-weight: 500;
            margin-top: 0.6rem;
        }

        /* ── Order Detail Section ── */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.5rem 0;
            border-bottom: 1px dashed var(--border);
            font-size: 0.88rem;
            gap: 0.5rem;
        }
        .info-row:last-of-type { border-bottom: none; }
        .info-label { color: var(--muted); flex-shrink: 0; }
        .info-value {
            font-weight: 500;
            color: var(--text);
            text-align: right;
        }

        .items-list { margin-top: 0.8rem; }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.45rem 0;
            border-bottom: 1px dashed var(--border);
            font-size: 0.85rem;
        }
        .item-row:last-child { border-bottom: none; }
        .item-name { color: var(--text); font-weight: 500; }
        .item-qty  { color: var(--muted); font-size: 0.8rem; margin-top: 2px; }
        .item-price { font-weight: 600; color: var(--primary); white-space: nowrap; }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0 0.25rem;
            margin-top: 0.5rem;
            border-top: 2px solid var(--primary);
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* ── Status Info ── */
        .status-info {
            background: linear-gradient(135deg, #fff8f0 0%, #fef3e8 100%);
            border: 1px solid #e8c99a;
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            margin-top: 1.2rem;
            font-size: 0.83rem;
            color: var(--text);
            line-height: 1.7;
        }
        .status-info strong { color: var(--primary); }

        /* ── Buttons ── */
        .btn-group {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .btn-confirm {
            width: 100%;
            padding: 0.85rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-confirm:hover  { background: #4e2a1e; }
        .btn-confirm:active { transform: scale(0.98); }
        .btn-confirm:disabled { background: #b0a09a; cursor: not-allowed; }

        .btn-back {
            width: 100%;
            padding: 0.75rem;
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.88rem;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: border-color 0.2s, color 0.2s;
        }
        .btn-back:hover { border-color: var(--accent); color: var(--accent); }

        /* ── Loading overlay ── */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1rem;
        }
        .overlay.show { display: flex; }
        .spinner {
            width: 48px; height: 48px;
            border: 5px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .overlay p { color: #fff; font-size: 0.95rem; font-weight: 500; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="page-header">
        <div class="logo">classic<span>coffee</span>.</div>
        <h1>Konfirmasi &amp; Pembayaran</h1>
        <p>Scan QR Code di bawah, lalu tunjukkan ke kasir untuk menyelesaikan pembayaran.</p>
    </div>

    <!-- Payment Wrapper -->
    <div class="payment-wrapper">

        <!-- QR Code Card -->
        <div class="card qr-card">
            <div class="card-title">🔖 QR Code Pesanan</div>
            <div id="qrcode"></div>
            <div class="qr-scan-label">📱 Scan dengan kamera HP / aplikasi QR reader</div>
            <p class="qr-hint">
                QR Code ini berisi detail pesanan Anda.<br>
                Tunjukkan kepada kasir untuk verifikasi dan proses pembayaran.
            </p>

            <!-- Tombol konfirmasi bayar -->
            <div class="btn-group">
                <button class="btn-confirm" id="btnConfirm">
                    ✅ Konfirmasi &amp; Kirim Pesanan
                </button>
                <a href="<?= base_url('/') ?>" class="btn-back" id="btnBack">
                    ← Kembali ke Menu
                </a>
            </div>
        </div>

        <!-- Order Detail Card -->
        <div class="card">
            <div class="card-title">📋 Detail Pesanan</div>

            <!-- Info pelanggan -->
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value" id="infoNama"><?= esc($order['nama_pelanggan']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value" id="infoEmail"><?= esc($order['email']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">No. Telepon</span>
                <span class="info-value"><?= esc($order['phone']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value"><?= esc($order['tanggal']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value" style="color:#c0782a;font-weight:600;">Menunggu Pembayaran</span>
            </div>

            <!-- Daftar item -->
            <div class="card-title" style="margin-top:1.2rem;">🛒 Item Pesanan</div>
            <div class="items-list" id="itemsList">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="item-row">
                        <div>
                            <div class="item-name"><?= esc($item['name']) ?></div>
                            <div class="item-qty">x<?= (int)($item['quantity'] ?? 1) ?></div>
                        </div>
                        <div class="item-price">
                            Rp <?= number_format((int)$item['price'] * (int)($item['quantity'] ?? 1), 0, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Total -->
            <div class="total-row">
                <span>Total Pembayaran</span>
                <span>Rp <?= number_format((int)$order['total_harga'], 0, ',', '.') ?></span>
            </div>

            <!-- Info pembayaran -->
            <div class="status-info">
                <strong>💡 Cara Pembayaran:</strong><br>
                1. Tunjukkan QR Code ini kepada kasir.<br>
                2. Klik <strong>"Konfirmasi &amp; Kirim Pesanan"</strong> untuk mendaftarkan pesanan ke sistem.<br>
                3. Kasir akan memverifikasi dan memproses pembayaran Anda.<br>
                4. Pembayaran dapat dilakukan secara <strong>Tunai atau Debit</strong>.
            </div>
        </div>

    </div><!-- /.payment-wrapper -->

    <!-- Loading Overlay -->
    <div class="overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <p>Memproses pesanan Anda...</p>
    </div>

    <!-- Data untuk QR (dikirim dari PHP ke JS) -->
    <script>
        // ===================================================
        // Data pesanan dari server (PHP → JS)
        // ===================================================
        const orderData = {
            nama_pelanggan : <?= json_encode($order['nama_pelanggan']) ?>,
            email          : <?= json_encode($order['email']) ?>,
            phone          : <?= json_encode($order['phone']) ?>,
            total_harga    : <?= (int)$order['total_harga'] ?>,
            tanggal        : <?= json_encode($order['tanggal']) ?>,
            items          : <?= json_encode($order['items']) ?>,
        };

        // ===================================================
        // Build QR payload — berisi semua data tabel yang relevan:
        // pesanan, menu_produk (nama, harga, qty), user info (nama, email, phone)
        // ===================================================
        function buildQrPayload(order) {
            const rupiah = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');

            let itemLines = order.items.map(it =>
                `  - ${it.name} (${it.quantity ?? 1}x @ ${rupiah(it.price)}) = ${rupiah((it.quantity ?? 1) * it.price)}`
            ).join('\n');

            return [
                '=== CLASSIC COFFEE — DETAIL PESANAN ===',
                '',
                '[DATA PELANGGAN]',
                `Nama    : ${order.nama_pelanggan}`,
                `Email   : ${order.email}`,
                `Telepon : ${order.phone}`,
                `Tanggal : ${order.tanggal}`,
                '',
                '[ITEM PESANAN (menu_produk)]',
                itemLines,
                '',
                `[TOTAL PEMBAYARAN] : ${rupiah(order.total_harga)}`,
                '',
                '[STATUS PESANAN]   : Menunggu Pembayaran',
                '[METODE BAYAR]     : Tunai / Debit (Kasir)',
                '',
                '=== Tunjukkan QR ini ke kasir ==='
            ].join('\n');
        }

        // ===================================================
        // Generate QR Code
        // ===================================================
        const qrPayload = buildQrPayload(orderData);

        new QRCode(document.getElementById('qrcode'), {
            text        : qrPayload,
            width       : 220,
            height      : 220,
            colorDark   : '#3d1f0f',
            colorLight  : '#faf6f0',
            correctLevel: QRCode.CorrectLevel.M
        });

        // ===================================================
        // Konfirmasi bayar — AJAX POST ke /checkout/confirm
        // ===================================================
        document.getElementById('btnConfirm').addEventListener('click', async function () {
            const btn     = this;
            const overlay = document.getElementById('loadingOverlay');

            btn.disabled      = true;
            btn.textContent   = 'Mengirim pesanan...';
            overlay.classList.add('show');

            try {
                const res = await fetch('<?= base_url('checkout/confirm') ?>', {
                    method  : 'POST',
                    headers : {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ confirm: true })
                });

                const result = await res.json();

                overlay.classList.remove('show');

                if (result.status === 'success') {
                    window.location.href = '<?= base_url('checkout/success') ?>';
                } else {
                    alert('Gagal mengirim pesanan: ' + (result.message || 'Silakan coba lagi.'));
                    btn.disabled    = false;
                    btn.textContent = '✅ Konfirmasi & Kirim Pesanan';
                }
            } catch (err) {
                overlay.classList.remove('show');
                alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                btn.disabled    = false;
                btn.textContent = '✅ Konfirmasi & Kirim Pesanan';
            }
        });
    </script>

</body>
</html>
