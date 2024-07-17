<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class DeclarationArch extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pic()
    {
        return $this->hasMany(PictureDecArch::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function rapport()
    {
        return $this->hasOne(RapportArch::class);
    }
}
