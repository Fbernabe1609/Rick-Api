<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteCharacter extends Model
{
//    use HasFactory;

    protected $fillable = ['user_id', 'character_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
