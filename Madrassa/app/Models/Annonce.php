<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class Annonce extends Model
{
    use HasFactory,Notifiable,HasApiTokens;


    public function pic()
    {
        return $this->hasMany(PictureAnn::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
