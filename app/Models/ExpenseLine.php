<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseLine extends Model
{
    use HasFactory;
    
    // Constantes pour les catégories de frais
    const CATEGORY_TRANSPORT = 'transport';
    const CATEGORY_ACCOMMODATION = 'accommodation';
    const CATEGORY_MEALS = 'meals';
    const CATEGORY_FUEL_TOLL = 'fuel_toll';
    const CATEGORY_OFFICE_SUPPLIES = 'office_supplies';
    const CATEGORY_TELECOMMUNICATIONS = 'telecommunications';
    const CATEGORY_TRAINING = 'training';
    const CATEGORY_REPRESENTATION = 'representation';
    const CATEGORY_OTHER = 'other';
    
    protected $fillable = [
        'expense_report_id',
        'description',
        'amount',
        'spent_on',
        'receipt_path',
        'category',
    ];

    protected $casts = [
        'spent_on' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relation inverse avec ExpenseReport
    public function expenseReport()
    {
        return $this->belongsTo(ExpenseReport::class);
    }
    
    // Méthode pour obtenir les labels des catégories
    public static function getCategoryLabels()
    {
        return [
            self::CATEGORY_TRANSPORT => 'Transport (train, avion, taxi)',
            self::CATEGORY_ACCOMMODATION => 'Hébergement (hôtel)',
            self::CATEGORY_MEALS => 'Repas d\'affaires',
            self::CATEGORY_FUEL_TOLL => 'Carburant et péage',
            self::CATEGORY_OFFICE_SUPPLIES => 'Fournitures de bureau',
            self::CATEGORY_TELECOMMUNICATIONS => 'Télécommunications',
            self::CATEGORY_TRAINING => 'Formation et séminaires',
            self::CATEGORY_REPRESENTATION => 'Frais de représentation',
            self::CATEGORY_OTHER => 'Autres frais professionnels',
        ];
    }
    
    // Méthode pour obtenir le label d'une catégorie
    public function getCategoryLabelAttribute()
    {
        $labels = self::getCategoryLabels();
        return $labels[$this->category] ?? 'Non défini';
    }
}
