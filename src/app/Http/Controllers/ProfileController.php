<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Purchase;
use App\Models\Profile;
use App\Models\Item;

class ProfileController extends Controller
{
    public function show(request $request){
        $page = $request->query('page', 'sell');
        $user =auth()->user();

        if($page === 'buy'){
            $items = $user->purchases()->with('item')->get()->pluck('item') ;
        }else{
            $items = $user->item;
        }

        $profile = auth()->user()->profile;


        return view('mypage.mypage', compact('profile', 'page', 'items', 'user'));
    }

    public function create(){
        $user = auth()->user();

        $profile = $user->profile;

        return view('mypage.profile', compact('profile', 'user'));
    }

    public function update(ProfileRequest $request){

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
        ]);

        $profile = $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        [
            'post_code' => $request->post_code,
            'address'  => $request->address,
            'building' => $request->building,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $profile->update(['image' => $path]);
        }

        return redirect('/');
    }

}
