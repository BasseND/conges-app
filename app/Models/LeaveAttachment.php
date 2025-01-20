<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_id',
        'filename',
        'original_filename',
        'mime_type',
        'size'
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
