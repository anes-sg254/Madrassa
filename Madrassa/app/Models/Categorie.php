<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Categorie extends Model
{
    use HasFactory , HasApiTokens , Notifiable;

    protected $fillable = [
        'name',
        'description',
        'idChedService'
    ];

    public function declaration()
    {
        return $this->hasMany( Declaration::class );
    }

    public function declarationArch()
    {
        return $this->hasMany( DeclarationArch::class );
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
