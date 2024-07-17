<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class PictureAnnArch extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    public function ann()
    {
        return $this->belongsTo('App\AnnonceArch');
    }
}
