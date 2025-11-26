<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::where('role', 'superadmin')->first() ?? User::first();

        $categoryBlueprints = [
            ['name' => 'Khutbah', 'slug' => 'khutbah', 'color' => '#0f766e', 'description' => 'Materi khutbah Jumat dan kultum pilihan untuk dai NU.'],
            ['name' => 'Program Sosial', 'slug' => 'program-sosial', 'color' => '#16a34a', 'description' => 'Gerakan sosial Lazisnu untuk pemberdayaan umat.', 'is_highlighted' => true],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'color' => '#0ea5e9', 'description' => 'Layanan kesehatan dan rumah sehat NU.', 'is_highlighted' => true],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'color' => '#a855f7', 'description' => 'Beasiswa dan penguatan madrasah/ponpes.', 'is_highlighted' => true],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'color' => '#f97316', 'description' => 'Program kemandirian ekonomi warga.', 'is_highlighted' => true],
            ['name' => 'Respon Bencana', 'slug' => 'respon-bencana', 'color' => '#ef4444', 'description' => 'Kesiapsiagaan dan tanggap darurat banjir, longsor, dll.'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan', 'color' => '#65a30d', 'description' => 'Ekonomi hijau dan gerakan hijau NU.', 'is_highlighted' => true],
        ];

        $categories = collect($categoryBlueprints)->mapWithKeys(fn ($cat) => [
            $cat['slug'] => Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'color' => $cat['color'] ?? null,
                    'description' => $cat['description'] ?? null,
                    'is_highlighted' => $cat['is_highlighted'] ?? false,
                ]
            )
        ]);

        $tagNames = [
            'Zakat',
            'Sedekah',
            'Khutbah',
            'Santri',
            'Ekonomi Hijau',
            'Respon Cepat',
            'Digitalisasi',
        ];

        $tags = collect($tagNames)->mapWithKeys(fn ($tag) => [
            $tag => Tag::updateOrCreate(
                ['slug' => Str::slug($tag)],
                ['name' => $tag, 'color' => Arr::random(['#0ea5e9', '#f97316', '#10b981', '#facc15'])]
            )
        ]);

        $articles = [
            [
                'title' => 'Gerakan Sedekah Pagi Lazisnu MWC NU Balongbendo',
                'category_slug' => 'program-sosial',
                'author' => 'Tim Media Lazisnu',
                'cover_image' => 'https://images.unsplash.com/photo-1454165205744-3b78555e5572?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Relawan Lazisnu Balongbendo menggalang kebaikan melalui program sedekah rutin setiap pagi.',
                'body' => '<p>Lazisnu MWC NU Balongbendo kembali menggulirkan program sedekah pagi sebagai wujud kepedulian terhadap sesama. Program ini menyasar masyarakat rentan dan para dhuafa di 23 desa.</p><p>Ketua Lazisnu menyampaikan bahwa gerakan ini merupakan sinergi antara NU ranting, banom, dan para donatur tetap. Setiap pekan, tim keliling menyalurkan paket pangan dan santunan pendidikan.</p>',
                'is_featured' => true,
                'tags' => ['Sedekah', 'Zakat'],
            ],
            [
                'title' => 'Launching Rumah Sehat Nahdlatul Ulama',
                'category_slug' => 'kesehatan',
                'author' => 'Kontributor NU Care',
                'cover_image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Lazisnu menghadirkan layanan kesehatan gratis untuk warga Balongbendo.',
                'body' => '<p>Rumah Sehat NU hadir dengan layanan dokter umum, cek tekanan darah, dan konseling gizi. Program ini menyasar lansia dan ibu hamil yang membutuhkan pendampingan.</p><p>Donasi dari para dermawan dioptimalkan untuk membeli peralatan medis sederhana dan stok vitamin.</p>',
                'tags' => ['Respon Cepat'],
            ],
            [
                'title' => 'Beasiswa Santri Produktif Angkatan II',
                'category_slug' => 'pendidikan',
                'author' => 'Lembaga Pendidikan Ma arif',
                'cover_image' => 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Program beasiswa Lazisnu mendorong santri NU lebih kreatif dan mandiri.',
                'body' => '<p>Beasiswa Santri Produktif membantu 35 santri pondok pesantren di Balongbendo. Selain biaya pendidikan, peserta juga mendapatkan pelatihan wirausaha digital.</p><p>Pendaftar dapat mengirimkan karya inovatif di bidang sosial, lingkungan, ataupun teknologi sederhana.</p>',
                'tags' => ['Santri', 'Digitalisasi'],
            ],
            [
                'title' => 'Rembug Zakat Desa Watesari',
                'category_slug' => 'ekonomi',
                'author' => 'Relawan Desa',
                'cover_image' => 'https://images.unsplash.com/photo-1485217988980-11786ced9454?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Mendorong kemandirian ekonomi melalui optimalisasi zakat dan infak lokal.',
                'body' => '<p>Rembug zakat menghadirkan tokoh masyarakat, pengurus ranting, dan pegiat UMKM. Forum ini menyepakati pemetaan mustahik prioritas dan pengembangan usaha tani.</p><p>Lazisnu bertindak sebagai motor pendampingan agar dana umat tepat sasaran dan berkelanjutan.</p>',
                'tags' => ['Zakat', 'Ekonomi Hijau'],
            ],
            [
                'title' => 'Lazisnu Tanggap Banjir Kali Porong',
                'category_slug' => 'respon-bencana',
                'author' => 'NU Peduli',
                'cover_image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Relawan NU menurunkan tim cepat untuk membantu korban banjir di wilayah Kali Porong.',
                'body' => '<p>Bantuan logistik, selimut, dan posko dapur umum digelar selama 5 hari. Warga terdampak memperoleh layanan kesehatan keliling serta trauma healing untuk anak-anak.</p><p>Kolaborasi dengan pemerintah desa memudahkan distribusi air bersih dan kebutuhan mendesak lainnya.</p>',
                'tags' => ['Respon Cepat'],
            ],
            [
                'title' => 'Festival Ekonomi Hijau Nahdliyin',
                'category_slug' => 'lingkungan',
                'author' => 'PC GP Ansor',
                'cover_image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
                'excerpt' => 'Menghidupkan ekonomi hijau melalui pameran produk ramah lingkungan.',
                'body' => '<p>Festival menghadirkan 20 UMKM binaan Lazisnu yang fokus pada produk organik, daur ulang, dan energi terbarukan sederhana. Pengunjung dapat belajar membuat eco-enzym dan kompos.</p><p>Acara disemarakkan penampilan banjari, workshop branding digital, dan klinik perizinan usaha mikro.</p>',
                'tags' => ['Ekonomi Hijau'],
            ],
        ];

        collect($articles)->each(function (array $article, int $index) use ($categories, $tags, $owner) {
            $slug = Str::slug($article['title']);
            $category = $categories[$article['category_slug']] ?? null;

            $articleModel = Article::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $article['title'],
                    'slug' => $slug,
                    'category_id' => $category?->id,
                    'author' => $article['author'],
                    'cover_image' => $article['cover_image'],
                    'excerpt' => $article['excerpt'],
                    'body' => $article['body'],
                    'is_featured' => $article['is_featured'] ?? false,
                    'published_at' => now()->subDays($index),
                    'user_id' => $owner?->id,
                ]
            );

            $tagIds = collect($article['tags'] ?? [])
                ->map(fn ($tagName) => $tags[$tagName]?->id)
                ->filter()
                ->all();

            $articleModel->tags()->sync($tagIds);
        });
    }
}
