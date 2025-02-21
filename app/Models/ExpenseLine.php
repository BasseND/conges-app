<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseLine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'expense_report_id',
        'description',
        'amount',
        'spent_on',
        'receipt_path',
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
}
