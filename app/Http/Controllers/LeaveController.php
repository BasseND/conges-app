<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveAttachment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::where('user_id', auth()->id())
                      ->with('attachments')
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:annual,sick,unpaid,other'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'min:10'],
            'attachments.*' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $duration = $end_date->diffInDays($start_date) + 1;

        // Vérifier le solde de congés uniquement pour les congés annuels et maladie
        $user = auth()->user();
        if ($request->type === 'annual' && $duration > $user->annual_leave_days) {
            return back()->withErrors(['start_date' => 'Solde de congés annuels insuffisant'])->withInput();
        }
        if ($request->type === 'sick' && $duration > $user->sick_leave_days) {
            return back()->withErrors(['start_date' => 'Solde de congés maladie insuffisant'])->withInput();
        }

        $leave = Leave::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'duration' => $duration,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        // Gérer les pièces jointes
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = $file->hashName(); // Génère un nom unique
                $file->store('leave-attachments'); // Stocke dans storage/app/leave-attachments

                LeaveAttachment::create([
                    'leave_id' => $leave->id,
                    'filename' => $filename,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize()
                ]);
            }
        }

        return redirect()->route('leaves.index')->with('success', 'Votre demande de congé a été soumise avec succès');
    }

    public function destroy(Leave $leave)
    {
        if ($leave->user_id !== auth()->id() || $leave->status !== 'pending') {
            abort(403);
        }

        // Supprimer les fichiers attachés
        foreach ($leave->attachments as $attachment) {
            Storage::delete('leave-attachments/' . $attachment->filename);
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Votre demande de congé a été annulée');
    }

    public function downloadAttachment(LeaveAttachment $attachment)
    {
        // Vérifier que l'utilisateur a le droit d'accéder à ce fichier
        if ($attachment->leave->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return Storage::download(
            'leave-attachments/' . $attachment->filename,
            $attachment->original_filename
        );
    }
}
