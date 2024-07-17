<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Attache extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = [
        'idDeclaration1',
        'idDeclaration2'
    ];

    public function dec(){
        return $this->belongsTo(Declaration::class);
    }
}
