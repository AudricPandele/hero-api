<?php

namespace App\Http\Controllers;

use App\Hero;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Users;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    /**
     * Login user
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = Users::where('email', $request->input('email'))->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(str_random(40));
            Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success', 'user' => Users::with('heros')->find($user->id)]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }

    /**
     * Register new user
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $newUser = Users::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $newHeroId = rand(1, 563);
        $newHero = Hero::find($newHeroId);
        $newUser->heros()->save($newHero);

        return $newUser;
    }

    public function detail($id)
    {
        $user = Users::with('heros')->find($id);

        return json_encode($user);
    }
}
