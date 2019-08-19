<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as Guzzle;

class HeroController extends Controller
{
    private $client;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Guzzle();
    }

    public function show()
    {
        $res = $this->client->get('https://akabab.github.io/superhero-api/api/all.json');
        $herosList = json_decode($res->getBody()->getContents());

        foreach ($herosList as $k => $hero) {
            $power = $this->getPower($hero);
            $herosList[$k]->powerstats->avg = $power['avg'];
            $herosList[$k]->powerstats->sum = $power['sum'];

            $rarity = $this->getRarity($hero);
            $herosList[$k]->rarity = $rarity['rarity'];
            $herosList[$k]->color = $rarity['color'];
        }
        return json_encode($herosList);
    }

    public function home()
    {
        $res = $this->client->get('https://akabab.github.io/superhero-api/api/all.json');
        $herosList = json_decode($res->getBody()->getContents());

        foreach ($herosList as $k => $hero) {
            $power = $this->getPower($hero);
            $herosList[$k]->powerstats->avg = $power['avg'];
            $herosList[$k]->powerstats->sum = $power['sum'];

            $rarity = $this->getRarity($hero);
            $herosList[$k]->rarity = $rarity['rarity'];
            $herosList[$k]->color = $rarity['color'];
        }

        $selected = array_rand($herosList, 30);
        shuffle($selected);
        $result = [];
        foreach ($selected as $id) {
            $result[] = $herosList[$id];
        }

        return json_encode($result);
    }

    public function detail($id)
    {
        $res = $this->client->get('https://akabab.github.io/superhero-api/api/id/' . $id . '.json');
        $hero = json_decode($res->getBody()->getContents());

        $power = $this->getPower($hero);
        $hero->powerstats->avg = $power['avg'];
        $hero->powerstats->sum = $power['sum'];

        $rarity = $this->getRarity($hero);
        $hero->rarity = $rarity['rarity'];
        $hero->color = $rarity['color'];

        return json_encode($hero);
    }

    private function getPower($hero)
    {
        $sum = $hero->powerstats->intelligence +
            $hero->powerstats->strength +
            $hero->powerstats->speed +
            $hero->powerstats->durability +
            $hero->powerstats->power +
            $hero->powerstats->combat;
        $avg = $sum / 6;

        return ['avg' => round($avg), 'sum' => $sum];
    }

    private function getRarity($hero)
    {
        switch (true) {
            case $hero->powerstats->avg < 71:
                $rarity = 1;
                $color = '#3498db';
                break;
            case $hero->powerstats->avg < 81:
                $rarity = 2;
                $color = '#b08d57';
                break;
            case $hero->powerstats->avg < 91:
                $rarity = 3;
                $color = '#bec2cb';
                break;
            case $hero->powerstats->avg > 90:
                $rarity = 4;
                $color = '#ffd700';
                break;

            default:
                $rarity = 1;
                $color = '#3498db';
                break;
        }

        return ['rarity' => $rarity, 'color' => $color];
    }
}
