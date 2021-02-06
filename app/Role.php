<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Import model User
use App\User;

class Role extends Model
{
    //Relación Many to Many
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
