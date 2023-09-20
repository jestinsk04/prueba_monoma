<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = ['name', 'source', 'owner', 'created_at', 'created_by'];

    // Define la relación con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class, 'owner');
    }
}