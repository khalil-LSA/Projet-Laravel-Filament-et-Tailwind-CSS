@php
    $record = $this->mountedTableActionRecord;
@endphp

<div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-blue-900 rounded-xl">
    {{-- Header avec image de fond --}}
    <div class="relative h-48 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 overflow-hidden">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <h2 class="text-4xl font-bold mb-2 drop-shadow-lg">{{ $record->name }}</h2>
                <p class="text-xl opacity-90">{{ $record->category->name ?? 'N/A' }} • {{ $record->brand->name ?? 'N/A' }}</p>
            </div>
        </div>
        {{-- Effet de vagues --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-50 dark:fill-gray-900"></path>
            </svg>
        </div>
    </div>

    <div class="p-8 space-y-8">
        {{-- Informations principales --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Informations générales</h3>
            </div>
            <div class="space-y-4">
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Slug</label>
                    <p class="text-base text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 px-4 py-2 rounded-lg font-mono text-sm">{{ $record->slug }}</p>
                </div>
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Catégorie</label>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        {{ $record->category->name ?? 'N/A' }}
                    </span>
                </div>
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Marque</label>
                    <span class="inline-flex items-center px-4 py-2 rounded-lg bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $record->brand->name ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Tarification et statut</h3>
            </div>
            <div class="space-y-4">
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 p-6 shadow-2xl">
                    <div class="relative z-10">
                        <label class="block text-xs font-bold text-white/80 uppercase tracking-wider mb-2">Prix de vente</label>
                        <p class="text-4xl font-black text-white drop-shadow-lg">{{ number_format($record->price, 0, ',', ' ') }} <span class="text-2xl">CFA</span></p>
                    </div>
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white/10"></div>
                    <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-40 w-40 rounded-full bg-white/10"></div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="relative overflow-hidden rounded-xl p-4 {{ $record->is_active ? 'bg-gradient-to-br from-green-400 to-emerald-600' : 'bg-gradient-to-br from-red-400 to-rose-600' }} shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-white/80 uppercase">Statut</p>
                                <p class="text-lg font-bold text-white mt-1">{{ $record->is_active ? 'Actif' : 'Inactif' }}</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-2">
                                @if($record->is_active)
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-xl p-4 {{ $record->in_stock ? 'bg-gradient-to-br from-blue-400 to-cyan-600' : 'bg-gradient-to-br from-gray-400 to-gray-600' }} shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-white/80 uppercase">Stock</p>
                                <p class="text-lg font-bold text-white mt-1">{{ $record->in_stock ? 'Disponible' : 'Rupture' }}</p>
                            </div>
                            <div class="bg-white/20 rounded-full p-2">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    @if($record->on_sale)
                        <span class="flex-1 inline-flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold shadow-lg animate-pulse">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            EN PROMOTION
                        </span>
                    @endif
                    @if($record->is_featured)
                        <span class="flex-1 inline-flex items-center justify-center px-4 py-3 rounded-xl bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            PRODUIT VEDETTE
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Images --}}
    @if($record->images)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Galerie d'images</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $images = is_string($record->images) ? json_decode($record->images, true) : $record->images;
                @endphp
                @if(is_array($images))
                    @foreach($images as $index => $image)
                        <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-rotate-1">
                            <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Image produit {{ $index + 1 }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <p class="text-white font-semibold text-sm">Image {{ $index + 1 }}</p>
                                </div>
                            </div>
                            <div class="absolute top-2 right-2 bg-white/90 dark:bg-gray-800/90 rounded-full px-2 py-1 text-xs font-bold text-gray-700 dark:text-gray-300">
                                #{{ $index + 1 }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    {{-- Description --}}
    @if($record->description)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Description détaillée</h3>
            </div>
            <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 p-6 border-l-4 border-indigo-500">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 bg-blue-500/10 rounded-full"></div>
                <p class="relative text-base text-gray-700 dark:text-gray-300 leading-relaxed">{!! nl2br(e($record->description)) !!}</p>
            </div>
        </div>
    @endif

    {{-- Dates --}}
    <div class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Créé le</label>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->created_at->format('d/m/Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $record->created_at->format('H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Modifié le</label>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->updated_at->format('d/m/Y') }}</p>
                    <p class="text-sm text-gray-500">{{ $record->updated_at->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>