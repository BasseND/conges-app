<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'data',
        'user_id',
        'created_by',
        'is_read',
        'read_at',
        'priority',
        'category',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Types de notifications
    const TYPE_LEAVE_REQUEST = 'leave_request';
    const TYPE_LEAVE_APPROVED = 'leave_approved';
    const TYPE_LEAVE_REJECTED = 'leave_rejected';
    const TYPE_EXPENSE_REQUEST = 'expense_request';
    const TYPE_EXPENSE_APPROVED = 'expense_approved';
    const TYPE_EXPENSE_REJECTED = 'expense_rejected';
    const TYPE_EXPENSE_PAID = 'expense_paid';
    const TYPE_USER_CREATED = 'user_created';
    const TYPE_USER_ROLE_CHANGED = 'user_role_changed';
    const TYPE_USER_DEPARTMENT_CHANGED = 'user_department_changed';
    const TYPE_CONTRACT_EXPIRING = 'contract_expiring';
    const TYPE_CONTRACT_EXPIRED = 'contract_expired';
    const TYPE_CONTRACT_UPDATED = 'contract_updated';

    // Catégories
    const CATEGORY_LEAVE = 'leave';
    const CATEGORY_EXPENSE = 'expense';
    const CATEGORY_USER = 'user';
    const CATEGORY_CONTRACT = 'contract';

    // Priorités
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    /**
     * Relation avec l'utilisateur concerné par la notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'utilisateur qui a créé la notification
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Marquer la notification comme lue
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Marquer la notification comme non lue
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Scope pour les notifications non lues
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope pour les notifications lues
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope pour une catégorie spécifique
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope pour une priorité spécifique
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope pour un utilisateur spécifique
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Créer une notification
     */
    public static function createNotification(
        string $type,
        string $title,
        string $message,
        int $userId,
        ?int $createdBy = null,
        ?array $data = null,
        string $priority = self::PRIORITY_NORMAL,
        ?string $category = null
    ): self {
        return self::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'user_id' => $userId,
            'created_by' => $createdBy,
            'data' => $data,
            'priority' => $priority,
            'category' => $category,
        ]);
    }

    /**
     * Obtenir la couleur CSS selon la priorité
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'text-gray-500',
            self::PRIORITY_NORMAL => 'text-blue-500',
            self::PRIORITY_HIGH => 'text-orange-500',
            self::PRIORITY_URGENT => 'text-red-500',
            default => 'text-gray-500',
        };
    }

    /**
     * Obtenir l'icône selon le type
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_LEAVE_REQUEST, self::TYPE_LEAVE_APPROVED, self::TYPE_LEAVE_REJECTED => 'calendar',
            self::TYPE_EXPENSE_REQUEST, self::TYPE_EXPENSE_APPROVED, self::TYPE_EXPENSE_REJECTED, self::TYPE_EXPENSE_PAID => 'receipt',
            self::TYPE_USER_CREATED => 'user-plus',
            self::TYPE_USER_ROLE_CHANGED, self::TYPE_USER_DEPARTMENT_CHANGED => 'user-edit',
            self::TYPE_CONTRACT_EXPIRING, self::TYPE_CONTRACT_EXPIRED, self::TYPE_CONTRACT_UPDATED => 'document',
            default => 'bell',
        };
    }

    /**
     * Obtenir la priorité traduite en français
     */
    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_LOW => 'Faible',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_HIGH => 'Élevé',
            self::PRIORITY_URGENT => 'Urgent',
            default => 'Normal',
        };
    }

    /**
     * Obtenir la catégorie traduite en français
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            self::CATEGORY_LEAVE => 'Congés',
            self::CATEGORY_EXPENSE => 'Notes de frais',
            self::CATEGORY_USER => 'Utilisateur',
            self::CATEGORY_CONTRACT => 'Contrat',
            default => 'Général',
        };
    }
}