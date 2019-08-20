<?php

namespace App\Http\Controllers;

use App\Hero;
use App\Powerstats;
use App\Biography;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;

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
        $herosList = Hero::with('powerstats', 'biography')->get();
        return json_encode($herosList);
    }

    public function home()
    {
        $herosList = Hero::with('powerstats', 'biography')->get()->toArray();
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
        $hero = Hero::with('powerstats', 'biography')->find($id);

        return json_encode($hero);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $heros = Hero::where('Name', 'like', "%{$search}%")->with('powerstats', 'biography')->get();

        return json_encode($heros);
    }
}
