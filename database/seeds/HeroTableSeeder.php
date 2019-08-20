<?php

use App\Biography;
use App\Powerstats;
use App\Hero;
use Illuminate\Database\Seeder;

class HeroTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('hero')->delete();
        DB::table('powerstats')->delete();
        DB::table('biography')->delete();

        $json = file_get_contents('https://akabab.github.io/superhero-api/api/all.json');
        $json_data = json_decode($json, true);

        foreach ($json_data as $hero) {
            $power = $this->getPower($hero);
            $rarity = $this->getRarity($power['avg']);
            $newHero = Hero::updateOrCreate(array(
                'name'      => $hero['name'],
                'images'    => $hero['images']['lg'],
                'rarity'    => $rarity['rarity'],
                'color'     => $rarity['color']
            ));

            Powerstats::updateOrCreate(array(
                'intelligence'  => $hero['powerstats']['intelligence'],
                'strength'      => $hero['powerstats']['strength'],
                'speed'         => $hero['powerstats']['speed'],
                'durability'    => $hero['powerstats']['durability'],
                'power'         => $hero['powerstats']['power'],
                'combat'        => $hero['powerstats']['combat'],
                'avg'           => $power['avg'],
                'sum'           => $power['sum'],
                'hero_id'       => $newHero->id
            ));

            // seed our trees table ---------------------
            Biography::updateOrCreate(array(
                'fullName'          => $hero['biography']['fullName'],
                'alterEgos'         => $hero['biography']['alterEgos'],
                'aliases'           => implode(",", $hero['biography']['aliases']),
                'placeOfBirth'      => $hero['biography']['placeOfBirth'],
                'firstAppearance'   => $hero['biography']['firstAppearance'],
                'publisher'         => $hero['biography']['publisher'],
                'alignment'         => $hero['biography']['alignment'],
                'hero_id'           => $newHero->id
            ));
        }
    }

    private function getPower($hero)
    {
        $sum = $hero['powerstats']['intelligence'] +
            $hero['powerstats']['strength'] +
            $hero['powerstats']['speed'] +
            $hero['powerstats']['durability'] +
            $hero['powerstats']['power'] +
            $hero['powerstats']['combat'];
        $avg = $sum / 6;

        return ['avg' => round($avg), 'sum' => $sum];
    }

    private function getRarity($avg)
    {
        switch (true) {
            case $avg < 71:
                $rarity = 1;
                $color = 'common';
                break;
            case $avg < 81:
                $rarity = 2;
                $color = 'rare';
                break;
            case $avg < 91:
                $rarity = 3;
                $color = 'epic';
                break;
            case $avg > 90:
                $rarity = 4;
                $color = 'legendary';
                break;

            default:
                $rarity = 1;
                $color = 'common';
                break;
        }

        return ['rarity' => $rarity, 'color' => $color];
    }
}
