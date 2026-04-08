<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chirp extends Model
{
    //Los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'message',
    ];

    //Relación de uno a muchos inversa con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
