<?php

namespace App\Controllers;

use App\Models\PesanKontakModel;

class KontakController extends BaseController
{
    public function kirim()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX() || $request->getMethod() === 'post') {
            $nama = $request->getPost('nama');
            $email = $request->getPost('email');
            $no_hp = $request->getPost('no_hp');
            $isi_pesan = $request->getPost('isi_pesan');

            if (empty($nama) || empty($email) || empty($isi_pesan)) {
                return $this->response->setStatusCode(400)->setBody('Data tidak lengkap');
            }

            $data = [
                'nama' => htmlspecialchars($nama),
                'email' => htmlspecialchars($email),
                'subjek' => 'Pesan dari Form Kontak (' . htmlspecialchars($no_hp) . ')',
                'pesan' => htmlspecialchars($isi_pesan),
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
