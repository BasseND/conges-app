<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
        }
        .max-w-7xl {
            max-width: 600px;
            margin: 15px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a365d;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        .status {
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 6px;
            display: inline-block;
            margin: 8px 0;
        }
        .approved {
            background-color: #c6f6d5;
            color: #276749;
        }
        .rejected {
            background-color: #fed7d7;
            color: #9b2c2c;
        }
        .details {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 6px;
            margin: 10px 0;
        }
        .details p {
            margin: 8px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #3182ce;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            color: #718096;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            .max-w-7xl {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="max-w-7xl">
        <div class="header">
            <h1>Statut de votre demande de congé</h1>
        </div>

        @if($user_email)
            <p>Bonjour {{ $user_name ?? 'collaborateur' }},</p>

            <p>Votre demande de congé a été mise à jour avec le statut suivant :</p>
            
            <div class="status {{ $status_label === 'Approuvée' ? 'approved' : 'rejected' }}">
                {{ $status_label === 'Approuvée' ? '✅ Demande Approuvée' : '❌ Demande Rejetée' }}
            </div>

            <div class="details">
                <p><strong>Période de congé :</strong></p>
                <p>Du {{ $start_date }} au {{ $end_date }}</p>
                @if($status_label === 'Rejetée' && $rejection_reason)
                <p><strong>Motif du refus :</strong><br>{{ $rejection_reason }}</p>
                @endif
            </div>

            <a href="{{ url("/leaves/{$leave->id}") }}" class="button">Consulter les détails</a>

            <div class="footer">
                <p>Cordialement,<br>
                <strong>{{ config('app.name') }}</strong></p>
            </div>
        @else
            <p class="error" style="color: #e53e3e; text-align: center; padding: 20px;">
                ⚠️ Erreur : Destinataire inconnu
            </p>
        @endif
    </div>
</body>
</html>
