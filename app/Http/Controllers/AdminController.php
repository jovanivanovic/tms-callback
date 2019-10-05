<?php

namespace App\Http\Controllers;

use App\Callback;
use App\Comment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function callbacks(Request $request)
    {
        return Callback::all();
    }

    public function view(Request $request, Callback $callback)
    {
        return $callback;
    }

    public function archive(Request $request, Callback $callback)
    {
        $callback->delete();

        return response()->json([ "message" => "Successfully archived the callback [{$callback->id}]." ]);
    }

    public function comment(Request $request, Callback $callback)
    {
        $request->merge(['user_id' => $request->user()->id]);
        $comment = $callback->comments()->create($request->all());

        return response()->json([ "message" => "Your comment has been posted.", "comments" => $callback->comments()->get() ]);
    }
}
