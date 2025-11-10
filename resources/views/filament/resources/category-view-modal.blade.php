@php
    $record = $this->mountedTableActionRecord;
@endphp

<div class="p-6 space-y-6">
    {{-- Informations principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations générales</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Nom de la catégorie</label>
                    <p class="text-sm text-gray-900">{{ $record->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Slug</label>
                    <p class="text-sm text-gray-900">{{ $record->slug }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Statut</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $record->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
        </div>
        
        {{-- Image --}}
        @if($record->image)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Image</h3>
                <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden mx-auto">
                    <img src="{{ asset('storage/' . $record->image) }}" 
                         alt="Image catégorie" 
                         class="w-full h-full object-cover">
                </div>
            </div>
        @endif
    </div>

    {{-- Statistiques --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h3>
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-blue-600">{{ $record->products()->count() }}</p>
                    <p class="text-sm text-gray-500">Produits</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600">{{ $record->products()->where('is_active', true)->count() }}</p>
                    <p class="text-sm text-gray-500">Produits actifs</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-orange-600">{{ $record->products()->where('in_stock', false)->count() }}</p>
                    <p class="text-sm text-gray-500">En rupture</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Dates --}}
    <div class="border-t pt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
            <div>
                <label class="block font-medium">Créé le</label>
                <p>{{ $record->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block font-medium">Modifié le</label>
                <p>{{ $record->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>