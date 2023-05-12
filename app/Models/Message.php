<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'room_id');
    }

    public function getAssetLinkAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
    }

    public function reciver()
    {
        return $this->belongsTo(User::class, 'reciver_id');
    }
}