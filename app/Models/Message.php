<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'content',
        'is_read',
        'read_at',
        'parent_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Relation avec l'expéditeur du message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relation avec le destinataire du message
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Relation avec le message parent (pour les réponses)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }

    /**
     * Relation avec les réponses à ce message
     */
    public function replies()
    {
        return $this->hasMany(Message::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * Relation avec les pièces jointes du message
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(MessageAttachment::class);
    }

    /**
     * Scope pour les messages d'une conversation
     */
    public function scopeConversation($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)->where('recipient_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)->where('recipient_id', $userId1);
        });
    }

    /**
     * Scope pour les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope pour les messages reçus par un utilisateur
     */
    public function scopeReceivedBy($query, $userId)
    {
        return $query->where('recipient_id', $userId);
    }

    /**
     * Scope pour les messages envoyés par un utilisateur
     */
    public function scopeSentBy($query, $userId)
    {
        return $query->where('sender_id', $userId);
    }

    /**
     * Marquer le message comme lu
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Vérifier si l'utilisateur peut accéder à ce message
     */
    public function canBeAccessedBy(User $user): bool
    {
        return $this->sender_id === $user->id || $this->recipient_id === $user->id;
    }

    /**
     * Obtenir le thread principal d'une conversation
     */
    public function getMainThread()
    {
        if ($this->parent_id) {
            return $this->parent->getMainThread();
        }
        return $this;
    }

    /**
     * Obtenir tous les messages d'un thread
     */
    public function getThreadMessages()
    {
        $mainThread = $this->getMainThread();
        return Message::where('id', $mainThread->id)
            ->orWhere('parent_id', $mainThread->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}