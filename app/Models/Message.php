<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        "body",
        "from_id",
        "to_id",
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}
