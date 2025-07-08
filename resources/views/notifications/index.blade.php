<x-app-layout>
   

    <div class="pb-12">
        <div class="mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
               <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-bgray-900 dark:text-white">
                            {{ __('Notifications') }}
                        </h2>
                        @if($notifications->where('is_read', false)->count() > 0)
                            <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-primary inline-flex items-center">
                                    Marquer tout comme lu
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="border rounded-lg p-4 {{ $notification->is_read ? 'bg-gray-50 dark:bg-gray-700' : 'bg-lime-50 dark:bg-lime-900' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->priority_color }}">
                                                    {{ $notification->priority_label }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $notification->category_label }}
                                                </span>
                                                @if(!$notification->is_read)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Nouveau
                                                    </span>
                                                @endif
                                            </div>
                                            <h3 class="text-lg font-semibold mt-2">{{ $notification->title }}</h3>
                                            <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                {{ $notification->created_at->diffForHumans() }}
                                                @if($notification->creator)
                                                    • Par {{ $notification->creator->first_name }} {{ $notification->creator->last_name }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            @if(!$notification->is_read)
                                                <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outlined-vert-extra text-sm">
                                                        Marquer comme lu
                                                    </button>
                                                </form>
                                            @endif
                                            @if(isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outlined-primary text-sm">
                                                    Voir détails
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12a1 1 0 011-1h4a1 1 0 011 1v12z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Aucune notification</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Vous n'avez aucune notification pour le moment.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>