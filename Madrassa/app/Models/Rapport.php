<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Rapport extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $fillable = [
        'id_rapport',
        'id_declaration',
        'file'
    ];

    public function declaration()
    {
        return $this->belongsTo('App\Declaration');
    }
}
