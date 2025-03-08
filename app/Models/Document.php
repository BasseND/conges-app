<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uploaded_by',
        'filename',
        'original_filename',
        'file_path',
        'type',
        'size',
        'description',
        'title',
        'expiration_date',
        'status',
    ];

    /**
     * Get the user that owns the document.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get human readable file size.
     */
    public function getHumanReadableSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the full storage path of the document.
     */
    public function getFullPathAttribute()
    {
        return Storage::path($this->file_path);
    }

    /**
     * Get the download URL for the document.
     */
    public function getDownloadUrlAttribute()
    {
        return route('admin.users.documents.download', [$this->user_id, $this->id]);
    }

    /**
     * Get the formatted status.
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'En attente',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'validated' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];
        
        return $classes[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the formatted expiration date.
     */
    public function getFormattedExpirationDateAttribute()
    {
        // Retourner la date d'expiration uniquement pour les pièces d'identité
        if ($this->type === 'identity') {
            return $this->expiration_date ? date('d/m/Y', strtotime($this->expiration_date)) : 'N/A';
        }
        
        return '-';
    }
}