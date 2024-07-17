<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class PictureDecArch extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    public function dec()
    {
        return $this->belongsTo('App\DeclarationArch');
    }
}
