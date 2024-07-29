<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conclusion extends Model
{
    use HasFactory;
    protected  $table ="conclusions";

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinataires()
    {
        return $this->belongsToMany(User::class, 'conclusion_user', 'conclusion_id', 'user_id_2')
                    ->withTimestamps(); // Si vous souhaitez conserver les timestamps sur la relation
    }

    // Dans le modèle conclusion
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }
}
