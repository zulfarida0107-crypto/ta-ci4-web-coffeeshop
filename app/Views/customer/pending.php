<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pending</title>
    <style>
        body { font-family: 'Poppins', sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #f7f7f7; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #ffc107; }
        a { display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background-color: #b6895b; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>⏳ Pembayaran Pending</h1>
        <p>Silakan selesaikan pembayaran Anda melalui instruksi Midtrans.</p>
        <a href="<?= base_url('/') ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>
