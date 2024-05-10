<?php

namespace Database\Seeders;

use App\Models\TermtypeSet;
use Illuminate\Database\Seeder;

class TermTypesSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TermtypeSet::factory()->createMany([
            [
                'termType' => '總統|副總統候選人',
                'termType_set' => ['柯文哲','侯友宜','賴清德','阿北','趙少康','蕭美琴'],
            ],
            [
                'termType' => '政黨',
                'termType_set' => ['國民黨','民眾黨','民進黨'],
            ],
            [
                'termType' => '其他',
                'termType_set' => ['柯粉','黃國昌','郭台銘','中國','藍白','分區','侯柯','台灣','美國','馬英九'],
            ],
        ]);
    }
}
