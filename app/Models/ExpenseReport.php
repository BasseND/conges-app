<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseReport extends Model
{
    use HasFactory;

    // Constantes pour les status
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PAID = 'paid';

    protected $fillable = [
        'user_id',
        'description',
        'status',
        'total_amount',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les lignes
    public function lines()
    {
        return $this->hasMany(ExpenseLine::class);
    }

    // Exemple de méthode pour recalcule du total
    public function recalculateTotal()
    {
        $this->total_amount = $this->lines()->sum('amount');
        $this->save();
    }

    // Get Status Label
    public static function getStatusLabelAttribute()
    {
        return [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_SUBMITTED => 'Soumis',
            self::STATUS_APPROVED => 'Approuvée',
            self::STATUS_REJECTED => 'Rejettée',
            self::STATUS_PAID => 'Payée',
        ];
    }
}
