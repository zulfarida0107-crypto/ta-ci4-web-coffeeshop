<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;

class CheckoutController extends Controller
{
    public function process()
    {
        $request = \Config\Services::request();

        if (strtolower($request->getMethod()) === 'post') {
            $total = $request->getPost('total');
            $itemsJSON = $request->getPost('items');
            $name = $request->getPost('name');
            $email = $request->getPost('email');
            $phone = $request->getPost('phone');

            if (empty($total) || empty($itemsJSON) || empty($name)) {
                return $this->response->setStatusCode(400)->setBody(json_encode(['status' => 'error', 'message' => 'Data tidak lengkap.']));
            }

            $itemDetails = json_decode($itemsJSON, true);

            if (!is_array($itemDetails)) {
                return $this->response->setStatusCode(400)->setBody(json_encode(['status' => 'error', 'message' => 'Format item tidak valid.']));
            }

            $grossAmount = 0;
            foreach ($itemDetails as $item) {
                $price = (int)$item['price'];
                $quantity = (int)$item['quantity'];
                $grossAmount += $price * $quantity;
            }

            try {
                // Kirim data pesanan ke Spring Boot API
                $postData = [
                    'namaPelanggan' => htmlspecialchars($name),
                    'idProduk' => 0, // Atau sesuaikan dengan detail produk pertama jika perlu
                    'jumlah' => 0, // Atau sesuaikan dengan detail produk pertama
                    'totalHarga' => (float) $grossAmount,
                    'statusPesanan' => 'Baru', // Status diubah menjadi Baru agar terdeteksi oleh Flutter
                    'tanggalPesanan' => date('Y-m-d H:i:s'),
                    'detailPesanan' => json_encode($itemDetails)
                ];
                
                api_post('/pesanan', $postData);

                // Kembalikan JSON success
                return $this->response->setContentType('application/json')->setBody(json_encode(['status' => 'success']));

            } catch (Exception $e) {
                return $this->response->setStatusCode(500)->setBody(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
            }
        }

        // Kalau bukan POST
        return redirect()->to('/');
    }

    public function success()
    {
        return view('customer/success');
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
