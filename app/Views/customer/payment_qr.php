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

    <style>
        :root {
            --primary:   #6b3a2a; /* Original dark brown */
            --accent:    #b6895b; /* Original gold */
            --light-bg:  #faf6f0; /* Original light beige */
            --card-bg:   #ffffff; /* Original white card */
            --text:      #2d1a0e; /* Original dark brown text */
            --muted:     #7a6655; /* Original muted text */
            --border:    #6b3a2a; /* Thicker dark brown border */
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
            position: relative;
            overflow-x: hidden;
        }

        /* ── Blurred Background Doodle ── */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('<?= base_url('img/bg_doodle.jpg') ?>');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            opacity: 0.18;
            z-index: -1;
            pointer-events: none;
        }

        /* ── Header ── */
        .page-header {
            text-align: center;
            margin-bottom: 2.2rem;
        }
        .page-header .logo {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        .page-header .logo span { color: var(--accent); }
        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text);
            margin-top: 0.6rem;
        }
        .page-header p {
            font-size: 0.95rem;
            color: var(--muted);
            margin-top: 0.4rem;
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
            border: 2.5px solid var(--border); /* Thickened border */
            padding: 1.8rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .card-title {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--primary);
            margin-bottom: 1.2rem;
            padding-bottom: 0.6rem;
            border-bottom: 2.5px solid var(--border); /* Thickened divider */
        }

        /* ── QR Section ── */
        .qr-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        #qrcode {
            margin: 1.2rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #qrcode img {
            border: 6px solid #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(107, 58, 42, 0.25);
            max-width: 100%;
            height: auto;
        }
        .qr-hint {
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: 0.8rem;
            line-height: 1.6;
        }
        .qr-scan-label {
            background: var(--light-bg);
            border: 2px solid var(--border); /* Thickened border */
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.82rem;
            color: var(--primary);
            font-weight: 600;
            margin-top: 0.6rem;
        }

        /* ── Order Detail Section ── */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.6rem 0;
            border-bottom: 1.5px dashed var(--accent); /* Thickened dashed divider */
            font-size: 0.9rem;
            gap: 0.5rem;
        }
        .info-row:last-of-type { border-bottom: none; }
        .info-label { color: var(--muted); flex-shrink: 0; }
        .info-value {
            font-weight: 600;
            color: var(--text);
            text-align: right;
        }

        .items-list { margin-top: 0.8rem; }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.55rem 0;
            border-bottom: 1.5px dashed var(--accent); /* Thickened dashed divider */
            font-size: 0.88rem;
        }
        .item-row:last-child { border-bottom: none; }
        .item-name { color: var(--text); font-weight: 500; }
        .item-qty  { color: var(--muted); font-size: 0.8rem; margin-top: 2px; }
        .item-price { font-weight: 600; color: var(--primary); white-space: nowrap; }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.9rem 0 0.25rem;
            margin-top: 0.8rem;
            border-top: 2.5px solid var(--border); /* Thickened total top border */
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* ── Status Info ── */
        .status-info {
            background: #fff8f0;
            border: 2px solid var(--accent); /* Thickened border */
            border-radius: 10px;
            padding: 1rem 1.2rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
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
            width: 100%;
        }
        .btn-confirm {
            width: 100%;
            padding: 0.9rem;
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
        .btn-confirm:disabled { background: #b0a09a; color: #fff; cursor: not-allowed; }

        .btn-back {
            width: 100%;
            padding: 0.8rem;
            background: transparent;
            color: var(--muted);
            border: 2px solid var(--border); /* Thickened border */
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

        /* ── Status Modal Overlay ── */
        .status-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(5px);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .status-modal-overlay.show {
            display: flex;
        }
        .status-modal-card {
            background: var(--card-bg);
            border: 2.5px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem 2rem;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            animation: modalPop 0.3s ease-out;
            position: relative;
        }
        @keyframes modalPop {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .status-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }
        .status-icon.success-icon {
            background: #e8f5e9;
            color: #2e7d32;
            border: 2.5px solid #2e7d32;
        }
        .status-icon.error-icon {
            background: #ffebee;
            color: #c62828;
            border: 2.5px solid #c62828;
        }

        .status-modal-card h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .status-modal-card h2.success-title {
            color: #2e7d32;
        }
        .status-modal-card h2.error-title {
            color: #c62828;
        }

        .status-modal-card .subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .modal-order-info {
            background: var(--light-bg);
            border: 2.5px solid var(--border);
            border-radius: 10px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .modal-order-info .row {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
            font-size: 0.9rem;
            border-bottom: 1.5px dashed var(--accent);
        }
        .modal-order-info .row:last-child { border-bottom: none; }
        .modal-order-info .label { color: var(--muted); }
        .modal-order-info .value { font-weight: 700; color: var(--text); }
        .modal-order-info .total-value { color: var(--primary) !important; font-size: 1.05rem !important; }

        .modal-info-box {
            background: #fffbf0;
            border: 2px solid #ffe0a0;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            font-size: 0.85rem;
            color: #7a5c20;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .reason-box {
            background: #fff5f5;
            border: 2px solid #ffcdd2;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            font-size: 0.85rem;
            color: #c62828;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            text-align: left;
            word-break: break-word;
        }

        /* ── Loading overlay ── */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
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
            border-top-color: var(--primary);
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
            <div class="card-title">QR Code Pesanan</div>
            <div id="qrcode">
                <img id="qrImage" alt="QR Code Pesanan" style="display: none;" />
            </div>
            <div class="qr-scan-label">Scan dengan kamera HP / aplikasi QR reader</div>
            <p class="qr-hint">
                QR Code ini berisi detail pesanan Anda.<br>
                Tunjukkan kepada kasir untuk verifikasi dan proses pembayaran.
            </p>

            <!-- Tombol konfirmasi bayar -->
            <div class="btn-group">
                <button class="btn-confirm" id="btnConfirm">
                    Konfirmasi &amp; Kirim Pesanan
                </button>
                <a href="<?= base_url('/') ?>" class="btn-back" id="btnBack">
                    Kembali ke Menu
                </a>
            </div>
        </div>

        <!-- Order Detail Card -->
        <div class="card">
            <div class="card-title">Detail Pesanan</div>

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
            <div class="card-title" style="margin-top:1.2rem;">Item Pesanan</div>
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
                <strong>Cara Pembayaran:</strong><br>
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

    <!-- Floating Notification Modal -->
    <div id="statusModal" class="status-modal-overlay">
        <div class="status-modal-card" id="statusModalCard">
            <!-- Content dynamically set by JS -->
        </div>
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
        
        const qrImage = document.getElementById('qrImage');
        qrImage.src = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${encodeURIComponent(qrPayload)}`;
        qrImage.style.display = 'block';

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
                    const formattedTotal = 'Rp ' + Number(result.total).toLocaleString('id-ID');
                    document.getElementById('statusModalCard').innerHTML = `
                        <div class="status-icon success-icon">
                            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h2 class="success-title">Pesanan Berhasil Dibuat!</h2>
                        <p class="subtitle">
                            Pesanan Anda telah tercatat di sistem.<br>
                            Silakan menuju kasir untuk menyelesaikan pembayaran.
                        </p>
                        <div class="modal-order-info">
                            <div class="row">
                                <span class="label">ID Pesanan</span>
                                <span class="value">#${result.order_id}</span>
                            </div>
                            <div class="row">
                                <span class="label">Nama Pelanggan</span>
                                <span class="value">${result.nama}</span>
                            </div>
                            <div class="row">
                                <span class="label">Total Pembayaran</span>
                                <span class="value total-value">${formattedTotal}</span>
                            </div>
                            <div class="row">
                                <span class="label">Status</span>
                                <span class="value" style="color:#c0782a;">Menunggu Pembayaran</span>
                            </div>
                        </div>
                        <div class="modal-info-box">
                            <strong>Terima kasih atas pesanan Anda!</strong><br>
                            Tim kami segera menyiapkan kopi Anda dengan penuh cinta.<br>
                            Pembayaran diterima secara <strong>Tunai atau Debit</strong> di kasir.
                        </div>
                        <a href="<?= base_url('/') ?>" class="btn-confirm" style="text-decoration:none; display:block;">Kembali ke Beranda</a>
                    `;
                    document.getElementById('statusModal').classList.add('show');
                } else {
                    showErrorModal(result.message || 'Gagal menyimpan pesanan ke server backend.');
                    btn.disabled    = false;
                    btn.textContent = 'Konfirmasi & Kirim Pesanan';
                }
            } catch (err) {
                overlay.classList.remove('show');
                showErrorModal(err.message || 'Terjadi kesalahan koneksi ke server.');
                btn.disabled    = false;
                btn.textContent = 'Konfirmasi & Kirim Pesanan';
            }
        });

        function showErrorModal(reason) {
            document.getElementById('statusModalCard').innerHTML = `
                <div class="status-icon error-icon">
                    <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h2 class="error-title">Pesanan Gagal Dikirim!</h2>
                <p class="subtitle">
                    Terjadi kesalahan saat memproses pesanan Anda ke server backend.
                </p>
                <div class="reason-box">
                    <strong>Penyebab kegagalan:</strong><br>
                    ${reason}
                </div>
                <button type="button" class="btn-confirm" onclick="document.getElementById('statusModal').classList.remove('show')">Tutup</button>
            `;
            document.getElementById('statusModal').classList.add('show');
        }    </script>

</body>
</html>
