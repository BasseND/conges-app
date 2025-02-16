<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { font-size: 24px; margin-bottom: 20px; }
        .status { font-weight: bold; margin: 15px 0; }
        .approved { color: #28a745; }
        .rejected { color: #dc3545; }
        .details { margin: 15px 0; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Statut de votre demande de congé</h1>
        
        <p>Bonjour {{ $leave->user->name }},</p>

        <p>Votre demande de congé a été mise à jour.</p>

        @if($user_email)
        <p>Bonjour {{ $user_name ?? 'collaborateur' }},</p>
        
        <div class="status {{ $status === 'approved' ? 'approved' : 'rejected' }}">
            Statut actuel : {{ $status === 'approved' ? 'Approuvée ✅' : 'Rejetée ❌' }}
        </div>

        <div class="details">
            <p><strong>Période :</strong> Du {{ $start_date }} au {{ $end_date }}</p>
            @if($status === 'rejected' && $rejection_reason)
            <p><strong>Motif du refus :</strong> {{ $rejection_reason }}</p>
            @endif
        </div>
        @else
        <p class="error">⚠️ Erreur : Destinataire inconnu</p>
        @endif

        <a href="{{ url("/leaves/{$leave->id}") }}" class="button">Voir les détails</a>

        <p>Cordialement,<br>
        {{ config('app.name') }}</p>
    </div>
</body>
</html>


