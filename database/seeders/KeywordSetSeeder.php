<?php

namespace Database\Seeders;
use App\Models\KeywordSet;
use Illuminate\Database\Seeder;
class KeywordSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KeywordSet::factory()->createMany([
            [
                'word' => '侯友宜',
                'set' => ['國民黨', '在野', '新北市', '韓國瑜', '馬英九', '朱立倫', '侯友宜', '藍', '徐巧芯', '親中', '一中各表'],
            ],
            [
                'word' => '賴清德',
                'set' => ['民進黨', '賴清德', '雞蛋', '民主進步黨', '蔡英文', '九二共識', '台獨', '綠營', '蕭美琴', '蔡政網軍', '綠', '潛艦', '陳建仁', '進口', '政府採購法'],
            ],
            [
                'word' => '柯文哲',
                'set' => ['台灣民眾黨', '新竹', '高虹安', '白營', '黃珊珊', '柯陣營', '柯P', '助理費', '白', '柯陣營', '柯美蘭', '黃國昌', '吳欣盈'],
            ],
            [
                'word' => '國民黨',
                'set' => ['國民黨','侯友宜'],
            ],
            [
                'word' => '民進黨',
                'set' => ['民進黨','賴清德'],
            ],
            [
                'word' => '民眾黨',
                'set' => ['民眾黨','柯文哲'],
            ]
            
        ]);
    }
}
