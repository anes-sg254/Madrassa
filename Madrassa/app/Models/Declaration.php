<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Declaration extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'lieu',
        'id_declaration',
        'idCategorie'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pic()
    {
        return $this->hasMany(Picture_dec::class);
    }

    public function attache()
    {
        return $this->hasMany(Attache::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function rapport()
    {
        return $this->hasOne(Rapport::class);
    }
}
