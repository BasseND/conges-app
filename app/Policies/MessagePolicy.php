<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Déterminer si l'utilisateur peut voir le message
     */
    public function view(User $user, Message $message): bool
    {
        return $message->canBeAccessedBy($user);
    }

    /**
     * Déterminer si l'utilisateur peut créer un message
     */
    public function create(User $user): bool
    {
        return true; // Tous les utilisateurs authentifiés peuvent créer des messages
    }

    /**
     * Déterminer si l'utilisateur peut envoyer un message à un destinataire spécifique
     */
    public function sendMessageTo(User $user, User $recipient): bool
    {
        // Un utilisateur ne peut pas s'envoyer un message à lui-même
        if ($user->id === $recipient->id) {
            return false;
        }

        // Si l'utilisateur est RH, il peut envoyer des messages à tous
        if ($user->isHR()) {
            return true;
        }

        // Si l'utilisateur n'est pas RH, il peut seulement envoyer des messages aux RH
        return $recipient->isHR();
    }

    /**
     * Déterminer si l'utilisateur peut répondre à un message
     */
    public function reply(User $user, Message $message): bool
    {
        return $message->canBeAccessedBy($user);
    }

    /**
     * Déterminer si l'utilisateur peut supprimer le message
     */
    public function delete(User $user, Message $message): bool
    {
        // Un utilisateur peut supprimer seulement les messages qu'il a envoyés
        return $message->sender_id === $user->id;
    }

    /**
     * Déterminer si l'utilisateur peut marquer le message comme lu
     */
    public function markAsRead(User $user, Message $message): bool
    {
        // Un utilisateur peut marquer comme lu seulement les messages qu'il a reçus
        return $message->recipient_id === $user->id;
    }
}