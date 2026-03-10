<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;

class ItemController extends Controller
{
    public function index(Request $request){
        session()->forget('purchase.shipping_edit');

        $tab = $request->query('tab');

        if ($tab === 'mylist' && !auth()->check()) {
            $items = collect();
            return view('index', compact('items', 'tab'));
        }

        if ($tab === 'mylist') {
            $query = auth()->user()->likes();
        } else {
            $query = Item::query();
        }

        if (auth()->check()) {
            $query->where('items.user_id', '!=', auth()->id());
        }

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $items = $query->get();

        return view('index', compact('items', 'tab'));
    }

    public function show($item_id){
        $item = Item::with(['comments.user', 'categories'])->findOrFail($item_id);

        $like = $item->likedUsers()->count();

        $comment = $item->comments()->count();

        $liked = auth()->check()
            ? $item->likedUsers()->where('user_id', auth()->id())->exists()
            : false;

        return view('items.show', compact('item', 'like', 'liked', 'comment'));
    }

    public function like($item_id){

        $user = auth()->user();

        $item = Item::findOrFail($item_id);

        $like = $item->likedUsers()->where('user_id', $user->id)->exists();

        if ($like) {
            $item->likedUsers()->detach($user->id);
        } else {
            $item->likedUsers()->syncWithoutDetaching([$user->id]);
        }

        return back();
    }

    public function sell(){
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function list(Request $request){
        $form = $request->all();

        $path = $request->file('image')->store('items', 'public');

        $form =[
            'user_id' => auth()->id(),
            'name' => $request->name,
            'image' => $path,
            'brand' => $request->brand,
            'condition_id' => $request->condition_id,
            'description' => $request->description,
            'price' => $request->price,
            'status' => '0',
            ];

        $item = Item::create($form);
        $item->categories()->sync($request->category_ids);

        return redirect('/');
    }

}
