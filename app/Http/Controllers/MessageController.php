<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{
    use AuthorizesRequests;

    /**
     * Afficher la liste des conversations
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer toutes les conversations de l'utilisateur
        $conversations = DB::table('messages as m1')
            ->select(
                'other_user.id as other_user_id',
                'other_user.first_name',
                'other_user.last_name',
                'other_user.email',
                'm1.subject',
                'm1.content',
                'm1.created_at as last_message_date',
                'm1.sender_id',
                DB::raw('COUNT(unread.id) as unread_count')
            )
            ->join(
                DB::raw('(
                    SELECT 
                        CASE 
                            WHEN sender_id = ' . $user->id . ' THEN recipient_id 
                            ELSE sender_id 
                        END as other_user_id,
                        MAX(created_at) as max_date
                    FROM messages 
                    WHERE sender_id = ' . $user->id . ' OR recipient_id = ' . $user->id . '
                    GROUP BY other_user_id
                ) as latest'),
                function ($join) {
                    $join->on('m1.created_at', '=', 'latest.max_date')
                         ->on(DB::raw('CASE WHEN m1.sender_id = ' . Auth::id() . ' THEN m1.recipient_id ELSE m1.sender_id END'), '=', 'latest.other_user_id');
                }
            )
            ->join('users as other_user', 'other_user.id', '=', 'latest.other_user_id')
            ->leftJoin('messages as unread', function ($join) use ($user) {
                $join->on('unread.sender_id', '=', 'other_user.id')
                     ->where('unread.recipient_id', '=', $user->id)
                     ->where('unread.is_read', '=', false);
            })
            ->where(function ($query) use ($user) {
                $query->where('m1.sender_id', $user->id)
                      ->orWhere('m1.recipient_id', $user->id);
            })
            ->groupBy('other_user.id', 'other_user.first_name', 'other_user.last_name', 'other_user.email', 'm1.subject', 'm1.content', 'm1.created_at', 'm1.sender_id')
            ->orderBy('last_message_date', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    /**
     * Afficher une conversation spécifique
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        
        // Vérifier que l'utilisateur peut communiquer avec cet utilisateur
        // Les RH peuvent voir toutes les conversations
        // Les employés ne peuvent voir que leurs conversations avec les RH
        if (!$currentUser->isHR() && !$user->isHR()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette conversation.');
        }
        
        // Récupérer tous les messages entre les deux utilisateurs
        $messages = Message::conversation($currentUser->id, $user->id)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Marquer les messages reçus comme lus
        Message::where('sender_id', $user->id)
            ->where('recipient_id', $currentUser->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('messages.show', compact('messages', 'user'));
    }

    /**
     * Afficher le formulaire de nouveau message
     */
    public function create(Request $request)
    {
        $recipientId = $request->get('recipient_id');
        $recipient = null;
        
        if ($recipientId) {
            $recipient = User::findOrFail($recipientId);
        }
        
        // Récupérer tous les utilisateurs RH si l'utilisateur actuel n'est pas RH
        // Sinon récupérer tous les employés
        $currentUser = Auth::user();
        $availableUsers = collect();
        
        if ($currentUser->isHR()) {
            // Si c'est un RH, il peut écrire à tous les employés
            $users = User::where('id', '!=', $currentUser->id)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
            $hrUsers = collect(); // Vide pour les RH
        } else {
            // Si c'est un employé, il peut seulement écrire aux RH
            $users = collect(); // Vide pour les employés
            $hrUsers = User::where('role', 'hr')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
        }

        return view('messages.create', compact('recipient', 'users', 'hrUsers'));
    }

    /**
     * Envoyer un nouveau message
     */
    public function store(Request $request)
    {
        // Gérer les deux formats : recipient_id (simple) et recipient_ids (multiple)
        if ($request->has('recipient_id')) {
            $request->validate([
                'recipient_id' => 'required|exists:users,id',
                'subject' => 'required|string|max:255',
                'content' => 'required|string|max:5000',
            ]);
            $recipientIds = [$request->recipient_id];
        } else {
            $request->validate([
                'recipient_ids' => 'required|array|min:1',
                'recipient_ids.*' => 'exists:users,id',
                'subject' => 'required|string|max:255',
                'content' => 'required|string|max:5000',
            ]);
            $recipientIds = $request->recipient_ids;
        }

        $currentUser = Auth::user();
        
        // Vérifier que l'utilisateur peut envoyer un message à tous les destinataires
        foreach ($recipientIds as $recipientId) {
            $recipient = User::findOrFail($recipientId);
            $this->authorize('sendMessageTo', [Message::class, $recipient]);
        }

        // Créer un message pour chaque destinataire
        foreach ($recipientIds as $recipientId) {
            Message::create([
                'sender_id' => $currentUser->id,
                'recipient_id' => $recipientId,
                'subject' => $request->subject,
                'content' => $request->content,
            ]);
        }

        // Rediriger vers la conversation avec le premier destinataire ou vers l'index
        if (count($recipientIds) === 1) {
            $recipient = User::findOrFail($recipientIds[0]);
            return redirect()->route('messages.show', $recipient)
                ->with('success', 'Message envoyé avec succès.');
        } else {
            return redirect()->route('messages.index')
                ->with('success', 'Message envoyé à ' . count($recipientIds) . ' destinataire(s) avec succès.');
        }
    }

    /**
     * Répondre à un message
     */
    public function reply(Request $request, Message $message)
    {
        // Vérifier que l'utilisateur peut accéder à ce message
        $this->authorize('view', $message);
        
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        $currentUser = Auth::user();
        
        // Déterminer le destinataire (l'autre personne dans la conversation)
        $recipientId = $message->sender_id === $currentUser->id 
            ? $message->recipient_id 
            : $message->sender_id;

        // Créer la réponse
        Message::create([
            'sender_id' => $currentUser->id,
            'recipient_id' => $recipientId,
            'subject' => 'Re: ' . $message->subject,
            'content' => $request->content,
            'parent_id' => $message->getMainThread()->id,
        ]);

        $recipient = User::find($recipientId);
        
        return redirect()->route('messages.show', $recipient)
            ->with('success', 'Réponse envoyée avec succès.');
    }

    /**
     * Supprimer un message
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        
        $message->delete();
        
        return redirect()->route('messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Marquer un message comme lu
     */
    public function markAsRead(Message $message)
    {
        $this->authorize('view', $message);
        
        if ($message->recipient_id === Auth::id()) {
            $message->markAsRead();
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Obtenir le nombre de messages non lus
     */
    public function unreadCount()
    {
        $count = Message::where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}