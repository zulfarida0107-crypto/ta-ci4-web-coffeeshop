<?php

namespace App\Controllers;

use App\Models\PesanKontakModel;

class KontakController extends BaseController
{
    public function kirim()
    {
        $request = \Config\Services::request();

        // CI4 getMethod() returns 'POST' or 'post' depending on environment, we check case-insensitively
        if ($request->isAJAX() || strtolower($request->getMethod()) === 'post') {
            $nama = $request->getPost('nama');
            $email = $request->getPost('email');
            $subjek = $request->getPost('subjek');
            $pesan = $request->getPost('pesan');

            if (empty($nama) || empty($email) || empty($subjek) || empty($pesan)) {
                return $this->response->setStatusCode(400)->setBody('Data tidak lengkap');
            }

            $data = [
                'nama' => htmlspecialchars($nama),
                'email' => htmlspecialchars($email),
                'subjek' => htmlspecialchars($subjek),
                'pesan' => htmlspecialchars($pesan),
                'tanggalDikirim' => date('Y-m-d H:i:s')
            ];

            $response = api_post('/pesan-kontak', $data);

            if (isset($response['success']) && $response['success'] == true) {
                return $this->response->setBody('berhasil');
            } else {
                return $this->response->setStatusCode(500)->setBody('Gagal menyimpan pesan ke API');
            }
        }

        return redirect()->to('/');
    }
}
