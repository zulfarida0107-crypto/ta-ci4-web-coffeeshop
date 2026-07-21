<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil — Classic Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6b3a2a;
            --accent:  #b6895b;
            --bg:      #faf6f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem;
            text-align: center;
            max-width: 460px;
            width: 100%;
        }
        .icon {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            display: block;
        }
        h1 {
            color: #2e7d32;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            color: #7a6655;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .order-info {
            background: #f8f4ee;
            border: 1px solid #e8ddd5;
            border-radius: 10px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .order-info .row {
            display: flex;
            justify-content: space-between;
            padding: 0.35rem 0;
            font-size: 0.88rem;
            border-bottom: 1px dashed #e8ddd5;
        }
        .order-info .row:last-child { border-bottom: none; }
        .order-info .label { color: #7a6655; }
        .order-info .value { font-weight: 600; color: #3d1f0f; }
        .total-value { color: var(--primary) !important; font-size: 1rem !important; }
        .info-box {
            background: #fffbf0;
            border: 1px solid #ffe0a0;
            border-radius: 8px;
            padding: 0.8rem 1rem;
            font-size: 0.82rem;
            color: #7a5c20;
            line-height: 1.7;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .btn:hover { background: #4e2a1e; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Pesanan Berhasil Dibuat!</h1>
        <p class="subtitle">
            Pesanan Anda telah tercatat di sistem.<br>
            Silakan menuju kasir untuk menyelesaikan pembayaran.
        </p>

        <?php if (!empty($order_id) && $order_id !== '-'): ?>
        <div class="order-info">
            <div class="row">
                <span class="label">ID Pesanan</span>
                <span class="value">#<?= esc($order_id) ?></span>
            </div>
            <?php if (!empty($nama)): ?>
            <div class="row">
                <span class="label">Nama Pelanggan</span>
                <span class="value"><?= esc($nama) ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($total)): ?>
            <div class="row">
                <span class="label">Total Pembayaran</span>
                <span class="value total-value">Rp <?= number_format((int)$total, 0, ',', '.') ?></span>
            </div>
            <?php endif; ?>
            <div class="row">
                <span class="label">Status</span>
                <span class="value" style="color:#c0782a;">Menunggu Pembayaran</span>
            </div>
        </div>
        <?php endif; ?>

        <div class="info-box">
            <strong>Terima kasih atas pesanan Anda!</strong><br>
            Tim kami segera menyiapkan kopi Anda dengan penuh cinta.<br>
            Pembayaran diterima secara <strong>Tunai atau Debit</strong> di kasir.
        </div>

        <a href="<?= base_url('/') ?>" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>
