<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract  extends Model
{
    use HasFactory;

    protected $table = 'contrats';

    protected $fillable = [
        'user_id',
        'type',
        'date_debut',
        'date_fin',
        'salaire_brut',
        'statut',
        'contrat_file',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'salaire_brut' => 'decimal:2'
    ];

    // Relation avec l'utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
