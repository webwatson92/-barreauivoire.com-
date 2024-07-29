<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavorisContact extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'tel', 'contact_id', 'user_id'];

    protected $table = "contactfavoris";


    public function users()
    {
        return $this->hasMany(User::class);
    }
}
