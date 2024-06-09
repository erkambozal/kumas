<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSettings::create([
            'name'=> 'iletisim',
            'data'=> '+90 544 226 64 16',
        ]);

        SiteSettings::create([
            'name'=> 'email',
            'data'=> 'info@tanerk.com',
        ]);

        SiteSettings::create([
            'name'=> 'adres',
            'data'=> 'Başak Mah. Yunus Emre Cad.
            Başakşehir – İstanbul / TÜRKİYE',
        ]);

    }
}
