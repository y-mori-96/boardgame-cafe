<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Boardgame;

class BoardgameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boardgames = [
            [
                'name' => 'ニムト',
                'barcode' => '4007396201550',
                'image' => '',
                'outline' => '牛を引き取らないようにカードを出せ！大人数でもできる大人気パーティゲーム',
                'description' => '牛、牛、牛。とにかく牛が主役のボードゲームです。獲得した牛の頭数が一番少なかったプレーヤーが勝利する、パーティ系カードゲームです。最大で１０人まで遊べるのが特徴です。',
                'video' => 'https://www.youtube.com/embed/KuxTF5JQKJc',
            ],
            [
                'name' => 'お邪魔者',
                'barcode' => '4580215110030',
                'image' => '',
                'outline' => '掘って掘って付き進め！金塊掘りとお邪魔者の正体隠匿系対戦ゲーム',
                'description' => 'お邪魔者は、ドワーフになってカードで道を繋げて金塊を掘り当てるボードゲームです。スタートのはしごのカードから、７枚分空けて伏せたカードを３枚配置し、そのうちの金塊があるカードまで道を繋げるように順番にカードを出していきます。しかし、そう簡単には掘り当てる事ができません。何故なら、一緒にゲームをしている人達の中に「お邪魔者」が紛れ込んでいるからです！',
                'video' => 'https://www.youtube.com/embed/UWZNcLaLtDs',
            ],
        ];
        
        foreach ($boardgames as $boardgame) {
            Boardgame::create($boardgame);
        }
    }
}
