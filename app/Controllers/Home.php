<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Data untuk link navigasi
        $navLinks = [
            '#home' => 'Home',
            '#about' => 'Tentang Kami',
            '#menu' => 'Menu',
            '#products' => 'Produk',
            '#contact' => 'Kontak',
        ];

        // Fetch menu dari API Spring Boot
        $response = api_get('/menu-produk');
        
        $menuItems = [];
        if (isset($response['success']) && $response['success'] == true) {
            $menuItems = $response['data'];
        }
        
        if (empty($menuItems)) {
            $menuItems = [
                ['img' => '1.jpg', 'alt' => 'Espresso', 'title' => 'Espresso', 'price' => 'IDR 15K'],
                ['img' => '2.jpg', 'alt' => 'Cappuccino', 'title' => 'Cappuccino', 'price' => 'IDR 25K'],
                ['img' => '3.jpg', 'alt' => 'Latte', 'title' => 'Latte', 'price' => 'IDR 28K'],
                ['img' => '4.jpg', 'alt' => 'Americano', 'title' => 'Americano', 'price' => 'IDR 18K'],
                ['img' => '5.jpg', 'alt' => 'Mocha', 'title' => 'Mocha', 'price' => 'IDR 30K'],
                ['img' => '6.jpg', 'alt' => 'Macchiato', 'title' => 'Macchiato', 'price' => 'IDR 20K'],
            ];
        } else {
            // Format ulang harga jika dari API
            foreach ($menuItems as &$item) {
                $gambar = $item['gambar'] ?? '';
                if (!empty($gambar)) {
                    if (strpos($gambar, 'http://') === 0 || strpos($gambar, 'https://') === 0) {
                        $item['img_src'] = $gambar;
                    } else {
                        // Jika hanya berupa nama file yang ada di folder public/img/menu/
                        if (file_exists(FCPATH . 'img/menu/' . $gambar)) {
                            $item['img_src'] = base_url('img/menu/' . $gambar);
                        } else {
                            // Cek jika gambar berupa path absolut
                            $item['img_src'] = $gambar;
                        }
                    }
                    $item['img'] = $gambar;
                } else {
                    $item['img'] = '1.jpg';
                    $item['img_src'] = base_url('img/menu/1.jpg');
                }
                
                $item['alt'] = $item['namaProduk'] ?? 'Kopi';
                $item['title'] = $item['namaProduk'] ?? 'Kopi';
                $harga = $item['harga'] ?? 0;
                $item['price'] = 'IDR ' . number_format($harga / 1000, 0) . 'K';
            }
        }

        $data = [
            'navLinks' => $navLinks,
            'menuItems' => $menuItems
        ];

        return view('customer/home', $data);
    }
}
