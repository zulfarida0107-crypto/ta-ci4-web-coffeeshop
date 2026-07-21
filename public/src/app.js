document.addEventListener("alpine:init", () => {
    // Global filter store
    Alpine.store("filter", {
        category: 'Semua',
        setCategory(cat) {
            this.category = cat;
        }
    });

    let defaultItems = [
        { id: 1, name: "Robusta Brazil",       img: "1.jpg", price: 20000, desc: "Biji kopi pilihan dari perkebunan Brazil dengan cita rasa nutty dan cokelat yang kuat. Sangrai medium, cocok untuk espresso dan pour-over.", kategori: "Kopi" },
        { id: 2, name: "Arabika Blend",         img: "2.jpg", price: 25000, desc: "Perpaduan sempurna biji Arabika dari berbagai dataran tinggi Indonesia. Aroma floral yang memikat dengan keasaman lembut dan aftertaste manis.", kategori: "Kopi" },
        { id: 3, name: "Primo Passo",           img: "3.jpg", price: 30000, desc: "Kopi spesialti single-origin dengan profil rasa fruity dan bright acidity. Sangrai light untuk menonjolkan karakter unik biji pilihan.", kategori: "Kopi" },
        { id: 4, name: "Aceh Gayo",             img: "4.jpg", price: 35000, desc: "Kopi premium dari dataran tinggi Gayo, Aceh. Rasa earthy yang kompleks, body tebal, dan aroma rempah yang khas. Sangrai medium-dark.", kategori: "Kopi" },
        { id: 5, name: "Sumatra Mandheling",    img: "5.jpg", price: 40000, desc: "Kopi ikonik dari Sumatera dengan body penuh dan rasa dark chocolate yang dalam. Proses wet-hulled menghasilkan profil rasa yang unik and bold.", kategori: "Kopi" },
    ];
    let items = defaultItems;
    if (window.unggulanProducts && window.unggulanProducts.length > 0) {
        items = window.unggulanProducts.map(item => ({
            id: parseInt(item.id),
            name: item.namaProduk || item.name || '',
            img: item.gambar || item.img || '1.jpg',
            img_src: item.img_src || '',
            price: parseInt(item.harga || item.price || 0),
            desc: item.deskripsi || item.desc || '',
            kategori: item.kategori || '',
            isUnggulan: true
        }));
    }

    Alpine.data("products", () => ({
        allItems: items,
        currentPage: 1,
        itemsPerPage: 6,
        get filteredItems() {
            return this.allItems;
        },
        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        },
        get items() {
            let start = (this.currentPage - 1) * this.itemsPerPage;
            let end = start + this.itemsPerPage;
            return this.filteredItems.slice(start, end);
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        goToPage(page) {
            this.currentPage = page;
        }
    }));

    let menuKamiItems = [];
    if (window.menuKamiProducts && window.menuKamiProducts.length > 0) {
        menuKamiItems = window.menuKamiProducts.map(item => {
            // Normalisasi kategori: trim whitespace, jaga kapitalisasi asli dari DB
            let rawKategori = item.kategori || item.kategoriProduk || '';
            let normKategori = rawKategori.trim();

            // Normalisasi ejaan yang tidak konsisten dari input Flutter/DB
            const kategoriMap = {
                'kopi'    : 'Kopi',
                'non-kopi': 'Non-Kopi',
                'nonkopi' : 'Non-Kopi',
                'non kopi': 'Non-Kopi',
                'pastry'  : 'Pastry',
            };
            let normalizedKategori = kategoriMap[normKategori.toLowerCase()] || normKategori;

            return {
                id       : parseInt(item.id) || 0,
                name     : item.namaProduk || item.name || '',
                img      : item.gambar     || item.img  || '1.jpg',
                img_src  : item.img_src    || '',
                price    : parseInt(item.harga || item.price || 0),
                desc     : item.deskripsi  || item.desc || '',
                kategori : normalizedKategori,
                isUnggulan: false
            };
        });
    }

    Alpine.data("menu", () => ({
        allItems: menuKamiItems,
        currentPage: 1,
        itemsPerPage: 6,
        init() {
            this.$watch('$store.filter.category', () => {
                this.currentPage = 1;
            });
        },
        get filteredItems() {
            let cat = Alpine.store('filter').category;
            if (!cat || cat === 'Semua') return this.allItems;
            return this.allItems.filter(item => {
                let itemKat = (item.kategori || '').trim().toLowerCase();
                let filterKat = cat.trim().toLowerCase();
                return itemKat === filterKat;
            });
        },
        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage);
        },
        get items() {
            let start = (this.currentPage - 1) * this.itemsPerPage;
            let end = start + this.itemsPerPage;
            return this.filteredItems.slice(start, end);
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        goToPage(page) {
            this.currentPage = page;
        }
    }));

    // Store untuk modal detail produk
    Alpine.store("modal", {
        show: false,
        product: null,
        _savedScrollY: 0,
        open(item) {
            this.product = item;
            this.show = true;
            // Simpan posisi scroll saat ini sebelum mengunci
            this._savedScrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = '-' + this._savedScrollY + 'px';
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.show = false;
            this.product = null;
            const savedY = this._savedScrollY;
            // Pulihkan body
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            document.body.style.overflow = '';
            // Nonaktifkan smooth-scroll sementara agar tidak animasi dari Y=0 ke savedY
            document.documentElement.style.scrollBehavior = 'auto';
            window.scrollTo(0, savedY);
            requestAnimationFrame(() => {
                document.documentElement.style.scrollBehavior = '';
            });
        }
    });

    Alpine.store("cart", {
        items: [],
        total: 0,
        quantity: 0,
        add(newItem) {
            // cek apakah ada barang yang sama di cart
            const cartItem = this.items.find((item) => item.id === newItem.id);

            // jika belum ada / cart masih kosong
            if (!cartItem) {
                this.items.push({ ...newItem, quantity: 1, total: newItem.price });
                this.quantity++;
                this.total += newItem.price;
            } else {
                // jika barang sudah ada, update item yang bersangkutan
                this.items = this.items.map((item) => {
                    if (item.id !== newItem.id) {
                        return item;
                    } else {
                        item.quantity++;
                        item.total = item.price * item.quantity;
                        this.quantity++;
                        this.total += item.price;
                        return item;
                    }
                });
            }
        },
        remove(id) {
            // ambil item yang mau diremove berdasarkan id nya
            const cartItem = this.items.find((item) => item.id === id);

            // Jika item ditemukan
            if (cartItem) {
                // jika item lebih dari 1
                if (cartItem.quantity > 1) {
                    this.items = this.items.map((item) => {
                        if (item.id === id) {
                            item.quantity--;
                            item.total = item.price * item.quantity;
                            this.quantity--;
                            this.total -= item.price;
                        }
                        return item;
                    });
                } else if (cartItem.quantity === 1) {
                    // jika barangnya sisa 1, hapus dari array
                    this.items = this.items.filter((item) => item.id !== id);
                    this.quantity--;
                    this.total -= cartItem.price;
                }
            }
        },
    });
});

// konversi ke Rupiah (DIPINDAHKAN KE ATAS AGAR DAPAT DIAKSES OLEH formatMessage)
const rupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
};

// kirim data ketika tombol checkout diklik
document.addEventListener('DOMContentLoaded', function () {
    // Form Validation
    const checkoutButton = document.querySelector(".checkout-button");
    const form = document.querySelector("#checkoutForm");

    if (!form || !checkoutButton) return;

    // PERBAIKAN KRITIS 1: Logika Validasi Form
    form.addEventListener("keyup", function () {
        let allFilled = true;
        
        // Iterasi melalui input form (name, email, phone)
        // Mulai dari 0 untuk input hidden dan 3 untuk input terlihat
        for (let i = 3; i < form.elements.length - 1; i++) { // -1 karena elemen terakhir adalah tombol submit
            if (form.elements[i].value.length === 0) {
                allFilled = false;
                break; // Hentikan loop segera setelah menemukan input kosong
            }
        }

        if (allFilled) {
            checkoutButton.disabled = false;
            checkoutButton.classList.remove("disabled");
        } else {
            checkoutButton.disabled = true;
            checkoutButton.classList.add("disabled");
        }
    });

    checkoutButton.addEventListener("click", async function (e) {
        e.preventDefault();

        if (checkoutButton.disabled) {
            alert('Harap isi semua detail pelanggan!');
            return;
        }

        const formData = new FormData(form);
        const data = new URLSearchParams(formData);
        const objData = Object.fromEntries(data);

        // Normalisasi item ke format {id, price, quantity, name}
        const rawItems = JSON.parse(objData.items);
        const normalizedItems = rawItems.map(item => ({
            id:       String(item.id),
            price:    parseInt(item.price),
            quantity: parseInt(item.quantity) || 1,
            name:     item.name
        }));
        data.set('items', JSON.stringify(normalizedItems));

        // Ubah teks tombol ke loading state
        checkoutButton.disabled   = true;
        checkoutButton.textContent = 'Memproses...';

        try {
            const response = await fetch("/checkout", {
                method: "POST",
                body: data,
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Bersihkan keranjang sebelum redirect ke halaman QR Payment
                Alpine.store("cart").items    = [];
                Alpine.store("cart").total    = 0;
                Alpine.store("cart").quantity = 0;

                // Tutup panel cart jika terbuka
                const cartPanel = document.querySelector('.shopping-cart');
                if (cartPanel) cartPanel.style.display = 'none';

                // Redirect ke halaman QR Code pembayaran
                window.location.href = result.redirect || "/checkout/payment";
            } else {
                alert("Checkout gagal: " + (result.message || "Unknown error"));
                checkoutButton.disabled   = false;
                checkoutButton.textContent = 'Checkout';
            }
        } catch (err) {
            console.error("Error during checkout:", err);
            alert("Terjadi kesalahan saat melakukan checkout. Cek console untuk detail.");
            checkoutButton.disabled   = false;
            checkoutButton.textContent = 'Checkout';
        }
    });
});

// PERBAIKAN KRITIS 2: Format pesan whatsapp
const formatMessage = (obj) => {
    // Pastikan obj.items di-parse dengan benar
    const items = JSON.parse(obj.items);
    
    // Gunakan map dengan string template yang benar dan fungsi rupiah()
    const itemDetails = items.map(
        (item) => `${item.name} (${item.quantity} x ${rupiah(item.price)}) = ${rupiah(item.total)}`
    ).join('\n '); // Pisahkan setiap item dengan baris baru

    return `*Data Customer*
Nama: ${obj.name}
Email: ${obj.email}
No HP: ${obj.phone}

*Data Pesanan*
 ${itemDetails}

*TOTAL:* ${rupiah(obj.total)}
Terima kasih.`;
};