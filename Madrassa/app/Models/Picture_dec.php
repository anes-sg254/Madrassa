<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Picture_dec extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = [
        'id_declaration',
        'picture'
    ];
    public function dec()
    {
        return $this->belongsTo('App\Declaration');
    }
}
