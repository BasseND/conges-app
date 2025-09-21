<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class HrAttestation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'attestation_type_id',
        'generated_by',
        'document_number',
        'status',
        'pdf_path',
        'data',
        'generated_at',
        'notes'
    ];

    protected $casts = [
        'data' => 'array',
        'generated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $dates = [
        'generated_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relation avec l'employé
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Relation avec le type d'attestation
     */
    public function attestationType()
    {
        return $this->belongsTo(AttestationType::class);
    }

    /**
     * Relation avec l'utilisateur qui a généré l'attestation
     */
    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pour filtrer par type d'attestation
     */
    public function scopeByType($query, $typeId)
    {
        return $query->where('attestation_type_id', $typeId);
    }

    /**
     * Scope pour filtrer par employé
     */
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope pour les attestations générées par les RH
     */
    public function scopeHrGenerated($query)
    {
        return $query->whereHas('attestationType', function ($q) {
            $q->whereIn('type', ['salary', 'employment', 'presence']);
        });
    }

    /**
     * Génère un numéro de document unique
     */
    public static function generateDocumentNumber($typeSystemName)
    {
        $prefix = strtoupper(substr($typeSystemName, 0, 3));
        $year = date('Y');
        $lastNumber = self::whereYear('created_at', $year)
            ->where('document_number', 'like', $prefix . '-' . $year . '-%')
            ->count();
        
        return $prefix . '-' . $year . '-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtient l'URL de téléchargement du PDF
     */
    public function getPdfUrlAttribute()
    {
        if ($this->pdf_path && Storage::exists($this->pdf_path)) {
            return Storage::url($this->pdf_path);
        }
        return null;
    }

    /**
     * Vérifie si le PDF existe
     */
    public function hasPdf()
    {
        return $this->pdf_path && Storage::exists($this->pdf_path);
    }

    /**
     * Supprime l'ancien PDF
     */
    public function deleteOldPdf()
    {
        if ($this->pdf_path && Storage::exists($this->pdf_path)) {
            Storage::delete($this->pdf_path);
        }
    }

    /**
     * Obtient le nom complet de l'employé
     */
    public function getEmployeeFullNameAttribute()
    {
        return $this->employee ? $this->employee->first_name . ' ' . $this->employee->last_name : 'N/A';
    }

    /**
     * Obtient le nom du type d'attestation
     */
    public function getAttestationTypeNameAttribute()
    {
        return $this->attestationType ? $this->attestationType->name : 'N/A';
    }

    /**
     * Obtient le nom de la personne qui a généré l'attestation
     */
    public function getGeneratedByNameAttribute()
    {
        return $this->generatedBy ? $this->generatedBy->first_name . ' ' . $this->generatedBy->last_name : 'N/A';
    }

    /**
     * Obtient le statut formaté
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Brouillon',
            'generated' => 'Généré',
            'sent' => 'Envoyé',
            'archived' => 'Archivé'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Obtient la classe CSS pour le statut
     */
    public function getStatusClassAttribute()
    {
        $classes = [
            'draft' => 'bg-gray-100 text-gray-800',
            'generated' => 'bg-blue-100 text-blue-800',
            'sent' => 'bg-green-100 text-green-800',
            'archived' => 'bg-yellow-100 text-yellow-800'
        ];

        return $classes[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Génère automatiquement un numéro de document lors de la création
        static::creating(function ($model) {
            if (!$model->document_number && $model->attestationType) {
                $model->document_number = self::generateDocumentNumber(
                    $model->attestationType->system_name
                );
            }

            if (!$model->generated_at) {
                $model->generated_at = now();
            }
        });

        // Supprime le PDF lors de la suppression définitive
        static::forceDeleted(function ($model) {
            $model->deleteOldPdf();
        });
    }

    /**
     * Constantes pour les statuts
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_GENERATED = 'generated';
    const STATUS_SENT = 'sent';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Obtient tous les statuts disponibles
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_GENERATED => 'Généré',
            self::STATUS_SENT => 'Envoyé',
            self::STATUS_ARCHIVED => 'Archivé'
        ];
    }
}