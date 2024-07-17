<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Service extends Model
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $fillable = [
        'id_categorie'
    ] ;

    public function categorie()
    {
        return $this->hasOne(Categorie::class);
    }
}
