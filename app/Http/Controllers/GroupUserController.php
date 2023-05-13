<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\GroupUser;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,$roomId)
    {
        if (!request()->hasValidSignature()) {
            abort(401);
        }
        $room = ChatRoom::findOrFail($roomId);
        GroupUser::create([
            'group_id' => $roomId,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'user_avatar' => auth()->user()->avatar,
            'joined_at' => now(),
        ]);
        return redirect('/r/' . $room->slug);
    }
}