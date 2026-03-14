// ===========================================
// 1. KONFIGURASI AWAL & ELEMEN DOM
// ===========================================
const btnTheme = document.getElementById('btn-theme');
const body = document.body;

// ===========================================
// 2. FITUR DARK MODE (LocalStorage)
// ===========================================
// Cek tema tersimpan di localStorage saat halaman dimuat
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    btnTheme.innerHTML = '<i class="bi bi-sun-fill"></i> Mode Terang';
}

// Event listener untuk tombol dark mode
btnTheme.addEventListener('click', function() {
    body.classList.toggle('dark-mode');

    if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        btnTheme.innerHTML = '<i class="bi bi-sun-fill"></i> Mode Terang';
    } else {
        localStorage.removeItem('theme');
        btnTheme.innerHTML = '<i class="bi bi-moon-stars-fill"></i> Mode Gelap';
    }
});

// ===========================================
// 3. FITUR WISHLIST (Array & LocalStorage)
// ===========================================

// Inisialisasi wishlist dari localStorage atau array kosong
let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

/**
 * Memperbarui tampilan jumlah item di wishlist (pada navbar)
 */
function updateWishlistCount() {
    const countElement = document.getElementById('wishlist-count');
    if (countElement) {
        countElement.textContent = wishlist.length;
    }
}

/**
 * Menambahkan motor ke wishlist
 * @param {string} namaMotor - Nama motor yang akan ditambahkan
 * @param {string} harga - Harga motor
 */
function tambahKeWishlist(namaMotor, harga) {
    // Cek apakah motor sudah ada di wishlist
    const exists = wishlist.some(item => item.nama === namaMotor);
    
    if (!exists) {
        // Tambah ke array wishlist
        wishlist.push({ 
            nama: namaMotor, 
            harga: harga,
            id: Date.now() + Math.random() // ID unik untuk setiap item
        });
        
        // Simpan ke localStorage
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        
        // Update tampilan
        updateWishlistCount();
        alert(`✅ ${namaMotor} ditambahkan ke wishlist!`);
        
        // Ubah tampilan tombol wishlist
        ubahTampilanTombolWishlist(namaMotor, true);
    } else {
        alert(`⚠️ ${namaMotor} sudah ada di wishlist!`);
    }
}

/**
 * Mengubah tampilan tombol wishlist (aktif/non-aktif)
 * @param {string} namaMotor - Nama motor
 * @param {boolean} isActive - Status aktif (true/false)
 */
function ubahTampilanTombolWishlist(namaMotor, isActive) {
    const tombolWishlist = document.querySelectorAll('.btn-wishlist');
    
    tombolWishlist.forEach(btn => {
        const cardBody = btn.closest('.card-body');
        if (cardBody) {
            const motorDiCard = cardBody.querySelector('.card-title').innerText;
            if (motorDiCard === namaMotor) {
                if (isActive) {
                    btn.classList.add('btn-danger');
                    btn.classList.remove('btn-outline-danger');
                    btn.innerHTML = '<i class="bi bi-heart-fill"></i> Di Wishlist';
                } else {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-danger');
                    btn.innerHTML = '<i class="bi bi-heart"></i> Wishlist';
                }
            }
        }
    });
}

/**
 * Menampilkan isi wishlist di modal (DENGAN TOMBOL HAPUS)
 */
function tampilkanWishlist() {
    const daftarWishlist = document.getElementById('daftar-wishlist');
    if (!daftarWishlist) return;

    // Kosongkan daftar wishlist
    daftarWishlist.innerHTML = '';

    if (wishlist.length === 0) {
        // Tampilkan pesan jika wishlist kosong
        daftarWishlist.innerHTML = '<li class="list-group-item text-center text-muted">✨ Belum ada motor di wishlist</li>';
    } else {
        // Tampilkan setiap item wishlist DENGAN TOMBOL HAPUS
        wishlist.forEach((item, index) => {
            daftarWishlist.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center" data-index="${index}">
                    <div>
                        <strong>${item.nama}</strong><br>
                        <small class="text-muted">${item.harga}</small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapusItemWishlist(${index})">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </li>
            `;
        });
    }
}

/**
 * Menghapus SATU ITEM SPESIFIK dari wishlist berdasarkan index
 * @param {number} index - Index item yang akan dihapus
 */
function hapusItemWishlist(index) {
    // Validasi index
    if (index < 0 || index >= wishlist.length) {
        alert('❌ Item tidak ditemukan!');
        return;
    }
    
    // Ambil nama motor sebelum dihapus (untuk keperluan notifikasi)
    const namaMotor = wishlist[index].nama;
    
    // Hapus item dari array berdasarkan index
    wishlist.splice(index, 1);
    
    // Simpan perubahan ke localStorage
    localStorage.setItem('wishlist', JSON.stringify(wishlist));
    
    // Update tampilan
    updateWishlistCount();
    tampilkanWishlist();
    
    // Kembalikan tampilan tombol wishlist di halaman utama
    ubahTampilanTombolWishlist(namaMotor, false);
    
    alert(`🗑️ ${namaMotor} dihapus dari wishlist!`);
}

/**
 * Menghapus SEMUA item dari wishlist
 */
function kosongkanWishlist() {
    if (wishlist.length === 0) {
        alert('⚠️ Wishlist sudah kosong!');
        return;
    }
    
    // Konfirmasi sebelum menghapus semua
    if (confirm('Apakah Anda yakin ingin mengosongkan semua wishlist?')) {
        // Simpan daftar motor sebelum dihapus
        const daftarMotor = [...wishlist];
        
        // Kosongkan array wishlist
        wishlist = [];
        
        // Hapus dari localStorage
        localStorage.removeItem('wishlist');
        
        // Update tampilan
        updateWishlistCount();
        tampilkanWishlist();
        
        // Kembalikan semua tombol wishlist ke keadaan semula
        daftarMotor.forEach(item => {
            ubahTampilanTombolWishlist(item.nama, false);
        });
        
        alert('✅ Semua wishlist telah dikosongkan!');
    }
}

// ===========================================
// 4. FITUR BELI (Event Listener & Stok)
// ===========================================

/**
 * Mengaktifkan tombol beli untuk semua motor
 */
function aktifkanTombolBeli() {
    const tombolBeli = document.querySelectorAll('.btn-beli');

    // Clone dan ganti tombol untuk menghapus event listener lama
    tombolBeli.forEach(function(button) {
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
    });

    // Tambahkan event listener ke tombol baru
    const tombolBaru = document.querySelectorAll('.btn-beli');
    
    tombolBaru.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ambil elemen card body
            const cardBody = e.target.closest('.card-body');
            if (!cardBody) return;
            
            // Ambil elemen stok
            const stokElement = cardBody.querySelector('.stok-text');
            if (!stokElement) return;
            
            // Parse stok
            let stokText = stokElement.innerText;
            let stok = parseInt(stokText.replace("Stok:", "").replace("Stok:", "").trim());

            if (stok > 0) {
                // Kurangi stok
                stok--;
                stokElement.innerHTML = "Stok: " + stok;
                
                // Ambil nama motor
                const namaMotor = cardBody.querySelector('.card-title').innerText;
                alert("✅ Berhasil membeli " + namaMotor + "!");
                
                // Jika stok habis, disable tombol
                if (stok === 0) {
                    e.target.disabled = true;
                    e.target.innerHTML = '<i class="bi bi-x-circle"></i> Habis';
                }
            } else {
                alert("❌ Stok Habis!");
                e.target.disabled = true;
                e.target.innerHTML = '<i class="bi bi-x-circle"></i> Habis';
            }
        });
    });
}

// ===========================================
// 5. FITUR TAMBAH MOTOR BARU (Bonus)
// ===========================================

/**
 * Menambahkan motor baru ke daftar
 */
function tambahMotorBaru() {
    // Ambil nilai dari form
    const namaMotor = document.getElementById('namaMotor')?.value;
    const merkMotor = document.getElementById('merkMotor')?.value;
    const tahunMotor = document.getElementById('tahunMotor')?.value;
    const ccMotor = document.getElementById('ccMotor')?.value;
    const hargaMotor = document.getElementById('hargaMotor')?.value;
    const stokMotor = document.getElementById('stokMotor')?.value;

    // Validasi input
    if (!namaMotor || !merkMotor || !tahunMotor || !ccMotor || !hargaMotor || !stokMotor) {
        alert('⚠️ Semua field harus diisi!');
        return;
    }

    if (parseInt(tahunMotor) < 2015 || parseInt(tahunMotor) > 2024) {
        alert('⚠️ Tahun harus antara 2015 - 2024!');
        return;
    }

    if (parseInt(hargaMotor) < 10000000) {
        alert('⚠️ Harga minimal Rp 10.000.000!');
        return;
    }

    // Format harga
    const hargaFormat = 'Rp ' + parseInt(hargaMotor).toLocaleString('id-ID');

    // Generate konten card baru
    const containerBarang = document.getElementById('container-barang');
    if (!containerBarang) return;
    
    const cardBaru = document.createElement('div');
    cardBaru.className = 'col-md-4 mb-4';
    cardBaru.innerHTML = `
        <div class="card h-100 motor-card">
            <img src="assets/default_motor.jpg" class="card-img-top" alt="${namaMotor}"/>
            <div class="card-body">
                <h5 class="card-title">${namaMotor}</h5>
                <p class="card-text harga-text">Harga: ${hargaFormat}</p>
                <p class="card-text stok-text">Stok: ${stokMotor}</p>
                <p class="card-text"><i class="bi bi-calendar"></i> Tahun: ${tahunMotor} | <i class="bi bi-cpu"></i> ${ccMotor}cc</p>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary btn-beli w-50 me-2">
                        <i class="bi bi-cart-check"></i> Beli
                    </button>
                    <button class="btn btn-outline-danger btn-wishlist w-50" onclick="tambahKeWishlist('${namaMotor}', '${hargaFormat}')">
                        <i class="bi bi-heart"></i> Wishlist
                    </button>
                </div>
            </div>
        </div>
    `;

    // Tambahkan card baru ke container
    containerBarang.appendChild(cardBaru);

    // Reset form
    const form = document.getElementById('formTambahMotor');
    if (form) form.reset();

    // Aktifkan kembali tombol beli untuk card baru
    aktifkanTombolBeli();

    alert('✅ Motor baru berhasil ditambahkan!');
}

// ===========================================
// 6. INISIALISASI SAAT HALAMAN DIMUAT
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    // Update jumlah wishlist
    updateWishlistCount();
    
    // Aktifkan tombol beli
    aktifkanTombolBeli();
    
    // Tandai motor yang sudah ada di wishlist
    if (wishlist.length > 0) {
        wishlist.forEach(item => {
            ubahTampilanTombolWishlist(item.nama, true);
        });
    }
});