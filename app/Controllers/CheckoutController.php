<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;

class CheckoutController extends Controller
{
    /**
     * Proses checkout: simpan data pesanan ke session lalu arahkan ke halaman QR payment.
     * QR Code akan di-generate di client-side (JS) menggunakan data dari session.
     */
    public function process()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();

        if (strtolower($request->getMethod()) === 'post') {
            $total    = $request->getPost('total');
            $itemsJSON = $request->getPost('items');
            $name     = $request->getPost('name');
            $email    = $request->getPost('email');
            $phone    = $request->getPost('phone');

            if (empty($total) || empty($itemsJSON) || empty($name)) {
                return $this->response
                    ->setStatusCode(400)
                    ->setBody(json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']));
            }

            $itemDetails = json_decode($itemsJSON, true);

            if (!is_array($itemDetails)) {
                return $this->response
                    ->setStatusCode(400)
                    ->setBody(json_encode(['status' => 'error', 'message' => 'Format item tidak valid.']));
            }

            // Hitung gross amount dari item detail
            $grossAmount = 0;
            foreach ($itemDetails as $item) {
                $price    = (int)$item['price'];
                $quantity = (int)($item['quantity'] ?? 1);
                $grossAmount += $price * $quantity;
            }

            // Simpan data pesanan ke session untuk ditampilkan di QR payment page
            $orderData = [
                'nama_pelanggan' => htmlspecialchars($name),
                'email'          => htmlspecialchars($email),
                'phone'          => htmlspecialchars($phone),
                'total_harga'    => (int)$grossAmount,
                'items'          => $itemDetails,
                'tanggal'        => date('d M Y, H:i') . ' WIB',
            ];

            $session->set('pending_order', $orderData);

            // Kembalikan JSON success → JS akan redirect ke halaman QR
            return $this->response
                ->setContentType('application/json')
                ->setBody(json_encode(['status' => 'success', 'redirect' => base_url('checkout/payment')]));
        }

        return redirect()->to('/');
    }

    /**
     * Halaman QR Payment: tampilkan QR Code berisi data pesanan.
     * Customer scan QR → data pesanan terbaca → klik "Konfirmasi Bayar" → simpan ke API.
     */
    public function payment()
    {
        $session   = \Config\Services::session();
        $orderData = $session->get('pending_order');

        if (empty($orderData)) {
            return redirect()->to('/');
        }

        return view('customer/payment_qr', ['order' => $orderData]);
    }

    /**
     * Konfirmasi pembayaran: kirim pesanan ke Spring Boot API, hapus session, redirect success.
     */
    public function confirm()
    {
        $session   = \Config\Services::session();
        $orderData = $session->get('pending_order');

        if (empty($orderData)) {
            return redirect()->to('/');
        }
        try {
            // Get first product ID to satisfy foreign key constraint
            $firstItem = reset($orderData['items']);
            $idProduk  = (isset($firstItem['id']) && (int)$firstItem['id'] > 0) ? (int)$firstItem['id'] : 1;

            // Kirim data pesanan ke Spring Boot API
            $postData = [
                'namaPelanggan' => $orderData['nama_pelanggan'],
                'idProduk'      => $idProduk,
                'jumlah'        => array_sum(array_column($orderData['items'], 'quantity')),
                'totalHarga'    => (float) $orderData['total_harga'],
                'statusPesanan' => 'Baru',
                'tanggalPesanan' => date('Y-m-d H:i:s'),
                'detailPesanan' => json_encode($orderData['items']),
            ];

            $apiResult = api_post('/pesanan', $postData);

            // Hapus session setelah berhasil disimpan
            $session->remove('pending_order');

            if (isset($apiResult['success']) && $apiResult['success'] === true) {
                // Simpan ID pesanan di session untuk ditampilkan di success page
                $pesananId = $apiResult['data']['id'] ?? '-';
                $session->set('last_order_id', $pesananId);
                $session->set('last_order_name', $orderData['nama_pelanggan']);
                $session->set('last_order_total', $orderData['total_harga']);

                return $this->response
                    ->setContentType('application/json')
                    ->setBody(json_encode(['status' => 'success']));
            } else {
                return $this->response
                    ->setStatusCode(500)
                    ->setBody(json_encode([
                        'status'  => 'error',
                        'message' => $apiResult['message'] ?? 'Gagal menyimpan pesanan ke server.',
                    ]));
            }
        } catch (Exception $e) {
            return $this->response
                ->setStatusCode(500)
                ->setBody(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
        }
    }

    public function success()
    {
        $session = \Config\Services::session();
        $data = [
            'order_id'   => $session->get('last_order_id') ?? '-',
            'nama'       => $session->get('last_order_name') ?? '-',
            'total'      => $session->get('last_order_total') ?? 0,
        ];
        $session->remove('last_order_id');
        $session->remove('last_order_name');
        $session->remove('last_order_total');
        return view('customer/success', $data);
    }

    public function pending()
    {
        return view('customer/pending');
    }

    public function error()
    {
        return view('customer/error');
    }
}
