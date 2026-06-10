<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;

class CheckoutController extends Controller
{
    public function process()
    {
        // Set Midtrans Server Key (Dummy sandbox key as in placeOrder.php)
        \Midtrans\Config::$serverKey    = 'YOUR_SERVER_KEY'; // GANTI DENGAN SERVER KEY ANDA
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $request = \Config\Services::request();

        // fetch API does not send X-Requested-With header by default, so we check for POST method
        if (strtolower($request->getMethod()) === 'post') {
            $total = $request->getPost('total');
            $itemsJSON = $request->getPost('items');
            $name = $request->getPost('name');
            $email = $request->getPost('email');
            $phone = $request->getPost('phone');

            if (empty($total) || empty($itemsJSON) || empty($name)) {
                return $this->response->setStatusCode(400)->setBody('Data tidak lengkap.');
            }

            $itemDetails = json_decode($itemsJSON, true);

            // Cek apakah itemDetails valid JSON
            if (!is_array($itemDetails)) {
                return $this->response->setStatusCode(400)->setBody('Format item tidak valid.');
            }

            $grossAmount = 0;
            foreach ($itemDetails as $item) {
                $price = (int)$item['price'];
                $quantity = (int)$item['quantity'];
                $grossAmount += $price * $quantity;
            }

            $orderId = 'ORDER-' . time() . '-' . rand(100, 999);

            $params = array(
                'transaction_details' => array(
                    'order_id'     => $orderId,
                    'gross_amount' => $grossAmount,
                ),
                'item_details'     => $itemDetails,
                'customer_details' => array(
                    'first_name' => htmlspecialchars($name),
                    'email'      => htmlspecialchars($email),
                    'phone'      => htmlspecialchars($phone),
                ),
            );

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Kirim data pesanan ke Spring Boot API
                $postData = [
                    'namaPelanggan' => htmlspecialchars($name),
                    'idProduk' => 0, // Atau sesuaikan dengan detail produk pertama jika perlu
                    'jumlah' => 0, // Atau sesuaikan dengan detail produk pertama
                    'totalHarga' => (float) $grossAmount,
                    'statusPesanan' => 'Dibayar', // Status awal dari midtrans
                    'tanggalPesanan' => date('Y-m-d H:i:s'),
                    'detailPesanan' => json_encode($itemDetails)
                ];
                
                api_post('/pesanan', $postData);

                // Kembalikan hanya token sebagai text agar kompatibel dengan app.js
                return $this->response->setBody($snapToken);

            } catch (Exception $e) {
                return $this->response->setStatusCode(500)->setBody('ERROR: ' . $e->getMessage());
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
