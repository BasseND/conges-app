<x-layout>
    <x-slot name="header">Détails de la Demande de Congé</x-slot>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Demande de {{ $leave->user->name }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Soumise le {{ $leave->created_at->format('d/m/Y à H:i') }}
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Type de congé</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($leave->type === 'annual') bg-green-100 text-green-800
                            @elseif($leave->type === 'sick') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($leave->type) }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Période</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        Du {{ $leave->start_date->format('d/m/Y') }} au {{ $leave->end_date->format('d/m/Y') }}
                        ({{ $leave->duration_days }} jour(s))
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Statut</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($leave->status === 'approved') bg-green-100 text-green-800
                            @elseif($leave->status === 'rejected') bg-red-100 text-red-800
                            @elseif($leave->status === 'cancelled') bg-gray-100 text-gray-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Motif</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $leave->reason }}
                    </dd>
                </div>
                @if($leave->status === 'rejected' && $leave->rejection_reason)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Motif du refus</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leave->rejection_reason }}
                        </dd>
                    </div>
                @endif
                @if($leave->approved_by)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Traité par</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $leave->approver->name }} le {{ $leave->approved_at->format('d/m/Y à H:i') }}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
        
        @if(auth()->user()->can('approve-leaves') && $leave->status === 'pending')
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
                <div class="flex justify-end space-x-3">
                    <form action="{{ route('leaves.reject', $leave) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-3">
                            <input type="text" name="rejection_reason" 
                                class="block w-64 border-gray-300 rounded-md shadow-sm focus:ring-secondary focus:border-secondary sm:text-sm"
                                placeholder="Motif du refus" required>
                            <button type="submit" class="btn-secondary" onclick="return confirm('Êtes-vous sûr de vouloir refuser cette demande ?')">
                                Refuser
                            </button>
                        </div>
                    </form>
                    <form action="{{ route('leaves.approve', $leave) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-primary" onclick="return confirm('Êtes-vous sûr de vouloir approuver cette demande ?')">
                            Approuver
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-layout>
