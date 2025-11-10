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
                    <label class="block text-sm font-medium text-gray-500">Nom du produit</label>
                    <p class="text-sm text-gray-900">{{ $record->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Slug</label>
                    <p class="text-sm text-gray-900">{{ $record->slug }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Catégorie</label>
                    <p class="text-sm text-gray-900">{{ $record->category->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Marque</label>
                    <p class="text-sm text-gray-900">{{ $record->brand->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tarification et statut</h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Prix</label>
                    <p class="text-sm text-gray-900 font-semibold">{{ number_format($record->price, 0, ',', ' ') }} CFA</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Statut</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $record->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">En stock</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->in_stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $record->in_stock ? 'Disponible' : 'Rupture' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">En promotion</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->on_sale ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $record->on_sale ? 'Oui' : 'Non' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Produit vedette</label>
                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $record->is_featured ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $record->is_featured ? 'Oui' : 'Non' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Images --}}
    @if($record->images)
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Images</h3>
            <div class="flex flex-wrap gap-3">
                @php
                    $images = is_string($record->images) ? json_decode($record->images, true) : $record->images;
                @endphp
                @if(is_array($images))
                    @foreach($images as $image)
                        <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="Image produit" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    {{-- Description --}}
    @if($record->description)
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-700">{!! nl2br(e($record->description)) !!}</p>
            </div>
        </div>
    @endif

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