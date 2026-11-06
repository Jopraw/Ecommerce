<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('products')->delete();
        DB::statement('PRAGMA foreign_keys = ON;');

        $products = [
            // Nike
            [
                'name' => 'Nike Air Jordan 1 Low Shadow',
                'category' => 'sneakers',
                'brand' => 'Nike',
                'price' => 2199000,
                'stock' => 15,
                'image' => 'products/nike_jordan_shadow.jpg',
                'description' => 'Siluet legendaris Air Jordan 1 Low dalam colorway Shadow ikonik (Black/Medium Grey). Material premium leather dengan bantalan Air-Sole untuk kenyamanan autentik streetwear.',
                'size_options' => ['40', '41', '42', '43', '44', '45'],
            ],
            [
                'name' => 'Nike Dunk Low Retro Panda',
                'category' => 'sneakers',
                'brand' => 'Nike',
                'price' => 1899000,
                'stock' => 24,
                'image' => 'products/nike_dunk_panda.jpg',
                'description' => 'Sneakers paling dicari sepanjang masa. Desain kontras hitam-putih klasik dengan konstruksi cupsole empuk, sangat fleksibel dipadukan dengan berbagai gaya outfit harian.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Nike Air Force 1 07 Triple White',
                'category' => 'sneakers',
                'brand' => 'Nike',
                'price' => 1549000,
                'stock' => 30,
                'image' => 'products/nike_af1_white.jpg',
                'description' => 'Sepatu kasual sepanjang masa dengan warna full white bersih. Menggunakan material kulit sintesis awet dengan sol tebal berteknologi Nike Air berdaya tahan tinggi.',
                'size_options' => ['38', '39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Nike Air Zoom Pegasus 40',
                'category' => 'sneakers',
                'brand' => 'Nike',
                'price' => 1799000,
                'stock' => 18,
                'image' => 'products/nike_pegasus_40.jpg',
                'description' => 'Sepatu lari performa tinggi dengan kombinasi busa React dan unit ganda Zoom Air. Menawarkan bantalan responsif dan stabilitas maksimal saat melangkah.',
                'size_options' => ['40', '41', '42', '43', '44', '45'],
            ],

            // New Balance
            [
                'name' => 'New Balance 550 White Green',
                'category' => 'sneakers',
                'brand' => 'New Balance',
                'price' => 1999000,
                'stock' => 20,
                'image' => 'products/nb_550_green.jpg',
                'description' => 'Revival sepatu basket retro tahun 1989. Dibalut kulit putih premium dengan aksen hijau botol klasik, memberikan estetika vintage 90-an yang autentik.',
                'size_options' => ['40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'New Balance 2002R Protection Pack',
                'category' => 'sneakers',
                'brand' => 'New Balance',
                'price' => 2799000,
                'stock' => 12,
                'image' => 'products/nb_2002r_cloud.jpg',
                'description' => 'Edisi deconstructed paling populer dengan aksen raw suede berlayer. Dilengkapi midsole N-ergy dan bantalan ABZORB untuk kenyamanan melangkah sepanjang hari.',
                'size_options' => ['40', '41', '42', '43', '44', '45'],
            ],
            [
                'name' => 'New Balance 574 Core Grey',
                'category' => 'sneakers',
                'brand' => 'New Balance',
                'price' => 1299000,
                'stock' => 28,
                'image' => 'products/nb_574_grey.jpg',
                'description' => 'Ikon New Balance sejati dengan siluet klasik berbahan suede dan mesh warna abu-abu khas NB. Sol ENCAP kokoh dan tahan lama.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],

            // Asics
            [
                'name' => 'Asics GEL-Kayano 14 Metallic Cream',
                'category' => 'sneakers',
                'brand' => 'Asics',
                'price' => 2499000,
                'stock' => 16,
                'image' => 'products/asics_kayano_14.jpg',
                'description' => 'Runner retro tahun 2000-an yang menjadi primadona gorpcore dan streetwear dunia. Mengusung teknologi GEL cushioning ikonis dengan detail metallic accents.',
                'size_options' => ['40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Asics GEL-NYC Graphite Grey',
                'category' => 'sneakers',
                'brand' => 'Asics',
                'price' => 2299000,
                'stock' => 14,
                'image' => 'products/asics_gel_nyc.jpg',
                'description' => 'Perpaduan desain warisan seri GEL-Nimbus 3 dan MC-PLUS V dengan tooling GEL-Cumulus 16 modern. Menghadirkan kenyamanan tingkat dewa dan tampilan futuristik.',
                'size_options' => ['40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Asics Novablast 4 Performance',
                'category' => 'sneakers',
                'brand' => 'Asics',
                'price' => 1899000,
                'stock' => 22,
                'image' => 'products/asics_novablast.jpg',
                'description' => 'Sepatu lari berenergi tinggi dengan bantalan FF BLAST PLUS ECO yang tebal dan membal. Desain geometris modern untuk pelari aktif.',
                'size_options' => ['40', '41', '42', '43', '44', '45'],
            ],

            // Ortuseight
            [
                'name' => 'Ortuseight Catalyst Legion V4 FG',
                'category' => 'formal',
                'brand' => 'Ortuseight',
                'price' => 599000,
                'stock' => 35,
                'image' => 'products/ortus_catalyst_v4.jpg',
                'description' => 'Sepatu performa andalan Ortuseight dengan bobot ultra ringan. Dilengkapi teknologi Quick-Fit dan Ort-Strap untuk cengkeraman kaki yang presisi dan stabil.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Ortuseight Hyperdrive 2.0 Runner',
                'category' => 'formal',
                'brand' => 'Ortuseight',
                'price' => 499000,
                'stock' => 40,
                'image' => 'products/ortus_hyperdrive.jpg',
                'description' => 'Sepatu lari lokal berstandar internasional dengan midsole CumulusFoam empuk dan upper breathable mesh. Ringan dan kuat untuk jarak jauh.',
                'size_options' => ['38', '39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Ortuseight Harvard Casual White',
                'category' => 'formal',
                'brand' => 'Ortuseight',
                'price' => 399000,
                'stock' => 30,
                'image' => 'products/ortus_harvard_white.jpg',
                'description' => 'Sepatu kasual harian bertema court sneaker minimalis. Nyaman dipakai ngampus, hangout, hingga kerja santai dengan bahan faux leather berkualitas.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],

            // Kanky
            [
                'name' => 'Kanky Yuga Makoto All Black',
                'category' => 'sandal',
                'brand' => 'Kanky',
                'price' => 388000,
                'stock' => 45,
                'image' => 'products/kanky_yuga_black.jpg',
                'description' => 'Sneakers lokal viral berteknologi insole Eva Foam empuk dengan konsep All-Black stealth. Didesain oleh desainer Jepang untuk kenyamanan jalan kaki ribuan langkah.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Kanky Story Honshu Olive Green',
                'category' => 'sandal',
                'brand' => 'Kanky',
                'price' => 349000,
                'stock' => 50,
                'image' => 'products/kanky_story_olive.jpg',
                'description' => 'Sneakers kasual lokal bergaya earthy-tone. Kombinasi suede sintetis dan rajutan sirkulasi udara optimal dengan sol fleksibel anti-slip.',
                'size_options' => ['38', '39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Kanky Classic Heritage Brown',
                'category' => 'sandal',
                'brand' => 'Kanky',
                'price' => 329000,
                'stock' => 38,
                'image' => 'products/kanky_classic_brown.jpg',
                'description' => 'Sepatu gaya vintage retro khas 70-an dengan warna coklat hangat. Tampilan berkelas dengan harga yang sangat ramah kantong mahasiswa.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],

            // Adidas
            [
                'name' => 'Adidas Samba OG Cloud White',
                'category' => 'sneakers',
                'brand' => 'Adidas',
                'price' => 2200000,
                'stock' => 20,
                'image' => 'products/adidas_samba_og.jpg',
                'description' => 'Sneakers paling tren di skena fashion global. Dibuat dengan upper kulit premium, T-toe suede lembut, dan gum sole klasik berkarakter.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],
            [
                'name' => 'Adidas Campus 00s Core Black',
                'category' => 'sneakers',
                'brand' => 'Adidas',
                'price' => 1800000,
                'stock' => 22,
                'image' => 'products/adidas_campus_00s.jpg',
                'description' => 'Mengadopsi era skate 2000-an dengan proporsi chunky, tali lebar (fat laces), dan suede tebal premium. Pilihan wajib streetwear masa kini.',
                'size_options' => ['39', '40', '41', '42', '43', '44'],
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
