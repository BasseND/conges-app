<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_id',
        'path',
        'name'
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
