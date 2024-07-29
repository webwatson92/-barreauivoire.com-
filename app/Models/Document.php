<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "documents";

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'document_user')->withTimestamps();
    // }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinataires()
    {
        return $this->belongsToMany(User::class, 'document_user', 'document_id', 'user_id_2')
                    ->withTimestamps(); // Si vous souhaitez conserver les timestamps sur la relation
    }

    // Dans le modèle Document
    public function destinataire()
    {
        return $this->belongsTo(User::class, 'user_id_2');
    }

}
