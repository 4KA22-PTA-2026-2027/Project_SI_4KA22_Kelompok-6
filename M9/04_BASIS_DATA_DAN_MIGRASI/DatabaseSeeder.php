<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TalentCategory;
use App\Models\KolProfile;
use App\Models\BrandProfile;
use App\Models\Job;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Siapamau',
            'email' => 'admin@siapamau.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Talent Categories
        $cats = ['Lifestyle', 'Beauty', 'Foodies', 'Sports', 'Tech', 'Fashion', 'Travel', 'Gaming'];
        foreach ($cats as $cat) {
            TalentCategory::create(['name' => $cat]);
        }

        // KOL Users
        $kols = [
            ['name' => 'Melvin Lifestyle', 'email' => 'melvin@kol.com', 'cat' => 1, 'followers' => 120000],
            ['name' => 'Tika Beauty', 'email' => 'tika@kol.com', 'cat' => 2, 'followers' => 85000],
            ['name' => 'Chandra Foodies', 'email' => 'chandra@kol.com', 'cat' => 3, 'followers' => 200000],
            ['name' => 'Nita Sports', 'email' => 'Nita@kol.com', 'cat' => 4, 'followers' => 55000],
            ['name' => 'Satria Tech', 'email' => 'Satria@kol.com', 'cat' => 5, 'followers' => 300000],
        ];
        foreach ($kols as $k) {
            $user = User::create([
                'name' => $k['name'],
                'email' => $k['email'],
                'password' => bcrypt('password'),
                'role' => 'kol',
            ]);
            KolProfile::create([
                'user_id' => $user->id,
                'talent_category_id' => $k['cat'],
                'bio' => 'Content creator passionate about sharing authentic content.',
                'followers' => $k['followers'],
                'instagram' => '@' . strtolower(str_replace(' ', '', $k['name'])),
                'rate' => rand(500000, 3000000),
            ]);
        }

        // Brand User
        $brand = User::create([
            'name' => 'Glow Skin Co.',
            'email' => 'brand@glowskin.com',
            'password' => bcrypt('password'),
            'role' => 'brand',
            'invitation_code' => 'BRAND2024',
        ]);
        BrandProfile::create([
            'user_id' => $brand->id,
            'company_name' => 'Glow Skin Co.',
            'description' => 'Premium skincare brand from Indonesia.',
            'website' => 'https://glowskin.co.id',
        ]);

        $brand2 = User::create([
            'name' => 'TechGadget ID',
            'email' => 'brand@techgadget.com',
            'password' => bcrypt('password'),
            'role' => 'brand',
            'invitation_code' => 'BRAND2024',
        ]);
        BrandProfile::create([
            'user_id' => $brand2->id,
            'company_name' => 'TechGadget ID',
            'description' => 'Latest gadget and electronics.',
        ]);

        // Jobs
        $jobs = [
            [
                'brand_id' => $brand->id,
                'talent_category_id' => 2,
                'title' => 'Skincare Review',
                'description' => 'Kami mencari konten kreator berpengalaman di bidang beauty dan skincare untuk mereview rangkaian produk terbaru "Eternal Radiance" dari Glow Skin Co. Review harus bersifat jujur, edukatif, dan estetik sesuai dengan brand guidelines kami.',
                'compensation' => 1500000,
                'deadline' => now()->addDays(3),
                'platform' => 'Instagram',
            ],
            [
                'brand_id' => $brand2->id,
                'talent_category_id' => 5,
                'title' => 'Gadget Unboxing',
                'description' => 'Cari konten kreator tech untuk membuat video unboxing dan review produk gadget terbaru kami. Konten harus menarik dan informatif untuk audience tech-savvy.',
                'compensation' => 3200000,
                'deadline' => now()->addDays(5),
                'platform' => 'YouTube',
            ],
            [
                'brand_id' => $brand->id,
                'talent_category_id' => 1,
                'title' => 'Morning Routine VLOG',
                'description' => 'Butuh konten kreator lifestyle untuk membuat video morning routine yang menampilkan produk skincare kami secara natural dan autentik.',
                'compensation' => 2000000,
                'deadline' => now()->addDays(7),
                'platform' => 'TikTok',
            ],
            [
                'brand_id' => $brand2->id,
                'talent_category_id' => 5,
                'title' => 'Laptop Review Campaign',
                'description' => 'Review laptop gaming terbaru kami dengan spesifikasi tinggi. Butuh creator yang paham dunia gaming dan teknologi.',
                'compensation' => 4500000,
                'deadline' => now()->addDays(10),
                'platform' => 'YouTube',
            ],
            [
                'brand_id' => $brand->id,
                'talent_category_id' => 6,
                'title' => 'Fashion x Beauty Collab',
                'description' => 'Kolaborasi konten fashion dan beauty untuk summer collection terbaru kami.',
                'compensation' => 2500000,
                'deadline' => now()->addDays(14),
                'platform' => 'Instagram',
            ],
        ];
        foreach ($jobs as $j) {
            Job::create($j);
        }
    }
}
