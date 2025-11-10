@php
    $record = $this->mountedTableActionRecord;
@endphp

<div class="p-6 space-y-6">
    {{-- Informations principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations personnelles</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Nom complet</label>
                    <p class="text-sm text-gray-900">{{ $record->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Email</label>
                    <p class="text-sm text-gray-900">{{ $record->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Email vérifié</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $record->email_verified_at ? 'Vérifié le ' . $record->email_verified_at->format('d/m/Y') : 'Non vérifié' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Avatar</h3>
            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto flex items-center justify-center">
                <span class="text-2xl font-bold text-gray-500">
                    {{ strtoupper(substr($record->name, 0, 2)) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    @if(method_exists($record, 'orders'))
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques d'achat</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <p class="text-2xl font-bold text-blue-600">{{ $record->orders()->count() }}</p>
                        <p class="text-sm text-gray-500">Commandes totales</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($record->orders()->sum('total'), 0, ',', ' ') }} CFA</p>
                        <p class="text-sm text-gray-500">Total dépensé</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-orange-600">{{ $record->orders()->where('status', 'pending')->count() }}</p>
                        <p class="text-sm text-gray-500">En attente</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Dates --}}
    <div class="border-t pt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
            <div>
                <label class="block font-medium">Inscrit le</label>
                <p>{{ $record->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block font-medium">Dernière connexion</label>
                <p>{{ $record->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>