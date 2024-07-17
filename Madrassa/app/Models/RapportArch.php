<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class RapportArch extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    public function declaration()
    {
        return $this->belongsTo('App\DeclarationArch');
    }

}
