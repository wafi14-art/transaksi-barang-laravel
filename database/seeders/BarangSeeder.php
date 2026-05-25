<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['kode_barang' => 'BR01', 'nama_barang' => 'Beras Premium 5kg', 'kategori' => 'Beras & Tepung', 'stok' => 46, 'harga_jual' => 82000, 'deskripsi' => 'Beras premium berkualitas untuk kebutuhan harian.', 'image' => '/images/products/beras-premium.png', 'thumbnail' => '/images/products/beras-premium.png'],
            ['kode_barang' => 'MG01', 'nama_barang' => 'Minyak Goreng 1L', 'kategori' => 'Minuman', 'stok' => 38, 'harga_jual' => 22000, 'deskripsi' => 'Minyak goreng kemasan modern, ringkas, siap pakai.', 'image' => '/images/products/minyak-goreng.png', 'thumbnail' => '/images/products/minyak-goreng.png'],
            ['kode_barang' => 'GL01', 'nama_barang' => 'Gula Pasir 1kg', 'kategori' => 'Bumbu & Dapur', 'stok' => 52, 'harga_jual' => 15000, 'deskripsi' => 'Gula pasir halus, manis alami untuk semua masakan.', 'image' => '/images/products/gula-pasir.png', 'thumbnail' => '/images/products/gula-pasir.png'],
            ['kode_barang' => 'TP01', 'nama_barang' => 'Tepung Terigu 1kg', 'kategori' => 'Beras & Tepung', 'stok' => 41, 'harga_jual' => 13000, 'deskripsi' => 'Tepung terigu multifungsi untuk roti, kue, dan gorengan.', 'image' => '/images/products/tepung-terigu.png', 'thumbnail' => '/images/products/tepung-terigu.png'],
            ['kode_barang' => 'SK01', 'nama_barang' => 'Susu Kental Manis', 'kategori' => 'Minuman', 'stok' => 56, 'harga_jual' => 12500, 'deskripsi' => 'Susu kental manis premium untuk minuman dan dessert.', 'image' => '/images/products/susu-kental-manis.png', 'thumbnail' => '/images/products/susu-kental-manis.png'],
            ['kode_barang' => 'MI01', 'nama_barang' => 'Mie Instan', 'kategori' => 'Makanan', 'stok' => 84, 'harga_jual' => 4200, 'deskripsi' => 'Mie instan cepat saji dengan cita rasa populer.', 'image' => '/images/products/mie-instan.png', 'thumbnail' => '/images/products/mie-instan.png'],
            ['kode_barang' => 'TC01', 'nama_barang' => 'Teh Celup', 'kategori' => 'Minuman', 'stok' => 66, 'harga_jual' => 9000, 'deskripsi' => 'Teh celup harum dan nikmat untuk sore hari.', 'image' => '/images/products/teh-celup.png', 'thumbnail' => '/images/products/teh-celup.png'],
            ['kode_barang' => 'KP01', 'nama_barang' => 'Kopi Sachet', 'kategori' => 'Minuman', 'stok' => 74, 'harga_jual' => 4800, 'deskripsi' => 'Kopi sachet praktis dengan aroma kopi kuat.', 'image' => '/images/products/kopi-sachet.png', 'thumbnail' => '/images/products/kopi-sachet.png'],
            ['kode_barang' => 'GD01', 'nama_barang' => 'Garam Dapur', 'kategori' => 'Bumbu & Dapur', 'stok' => 95, 'harga_jual' => 5000, 'deskripsi' => 'Garam dapur kristal bersih untuk semua hidangan.', 'image' => '/images/products/garam-dapur.png', 'thumbnail' => '/images/products/garam-dapur.png'],
            ['kode_barang' => 'KM01', 'nama_barang' => 'Kecap Manis', 'kategori' => 'Bumbu & Dapur', 'stok' => 49, 'harga_jual' => 17000, 'deskripsi' => 'Kecap manis premium dengan rasa seimbang.', 'image' => '/images/products/kecap-manis.png', 'thumbnail' => '/images/products/kecap-manis.png'],
            ['kode_barang' => 'SS01', 'nama_barang' => 'Saus Sambal', 'kategori' => 'Bumbu & Dapur', 'stok' => 58, 'harga_jual' => 15000, 'deskripsi' => 'Saus sambal modern, cocok untuk semua sajian pedas.', 'image' => '/images/products/saus-sambal.png', 'thumbnail' => '/images/products/saus-sambal.png'],
            ['kode_barang' => 'SC01', 'nama_barang' => 'Sabun Cuci Piring', 'kategori' => 'Kebersihan', 'stok' => 64, 'harga_jual' => 11000, 'deskripsi' => 'Sabun cuci piring dengan busa lembut dan wangi segar.', 'image' => '/images/products/sabun-cuci-piring.png', 'thumbnail' => '/images/products/sabun-cuci-piring.png'],
            ['kode_barang' => 'DT01', 'nama_barang' => 'Detergen Bubuk', 'kategori' => 'Kebersihan', 'stok' => 47, 'harga_jual' => 24000, 'deskripsi' => 'Detergen bubuk serbaguna untuk pakaian bersih wangi.', 'image' => '/images/products/detergen-bubuk.png', 'thumbnail' => '/images/products/detergen-bubuk.png'],
            ['kode_barang' => 'TG01', 'nama_barang' => 'Tisu Gulung', 'kategori' => 'Kebersihan', 'stok' => 78, 'harga_jual' => 12000, 'deskripsi' => 'Tisu gulung lembut untuk kebutuhan rumah harian.', 'image' => '/images/products/tisu-gulung.png', 'thumbnail' => '/images/products/tisu-gulung.png'],
            ['kode_barang' => 'AM01', 'nama_barang' => 'Air Mineral', 'kategori' => 'Minuman', 'stok' => 88, 'harga_jual' => 7000, 'deskripsi' => 'Air mineral kemasan premium untuk hidrasi cepat.', 'image' => '/images/products/air-mineral.png', 'thumbnail' => '/images/products/air-mineral.png'],
            ['kode_barang' => 'BK01', 'nama_barang' => 'Biskuit', 'kategori' => 'Makanan', 'stok' => 63, 'harga_jual' => 14500, 'deskripsi' => 'Biskuit renyah untuk camilan keluarga.', 'image' => '/images/products/biskuit.png', 'thumbnail' => '/images/products/biskuit.png'],
            ['kode_barang' => 'CK01', 'nama_barang' => 'Cokelat', 'kategori' => 'Makanan', 'stok' => 52, 'harga_jual' => 19500, 'deskripsi' => 'Cokelat batangan dengan rasa premium.', 'image' => '/images/products/cokelat.png', 'thumbnail' => '/images/products/cokelat.png'],
            ['kode_barang' => 'KC01', 'nama_barang' => 'Kacang Kulit', 'kategori' => 'Makanan', 'stok' => 56, 'harga_jual' => 14000, 'deskripsi' => 'Kacang kulit gurih, cocok untuk cemilan cepat.', 'image' => '/images/products/kacang-kulit.png', 'thumbnail' => '/images/products/kacang-kulit.png'],
            ['kode_barang' => 'KK01', 'nama_barang' => 'Keripik Kentang', 'kategori' => 'Makanan', 'stok' => 57, 'harga_jual' => 13000, 'deskripsi' => 'Keripik kentang renyah dalam kemasan modern.', 'image' => '/images/products/keripik-kentang.png', 'thumbnail' => '/images/products/keripik-kentang.png'],
            ['kode_barang' => 'SB01', 'nama_barang' => 'Susu Bubuk', 'kategori' => 'Minuman', 'stok' => 70, 'harga_jual' => 39000, 'deskripsi' => 'Susu bubuk praktis dengan nutrisi lengkap.', 'image' => '/images/products/susu-bubuk.png', 'thumbnail' => '/images/products/susu-bubuk.png'],
        ];

        foreach ($products as $product) {
            Barang::updateOrCreate(['kode_barang' => $product['kode_barang']], $product);
        }
    }
}
