<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $itemId){

        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $itemId,
            'comment' => $request->comment,
        ]);

        return back();
    }

}
