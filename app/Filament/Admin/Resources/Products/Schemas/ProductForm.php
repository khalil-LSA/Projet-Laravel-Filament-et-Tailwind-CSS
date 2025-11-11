<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ========================================
                // SECTION: INFORMATIONS PRINCIPALES
                // ========================================
                Section::make('Informations principales')
                    ->description('Identifiez votre produit de manière unique et descriptive')
                    ->icon('heroicon-o-information-circle')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom du produit')
                                    ->required()
                                    ->maxLength(255)
                                    ->reactive()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                                    ->prefixIcon('heroicon-o-tag')
                                    ->prefixIconColor('primary')
                                    ->placeholder('Ex: iPhone 15 Pro Max')
                                    ->helperText('Saisissez un nom descriptif et unique pour votre produit')
                                    ->columnSpan(1),
                                
                                TextInput::make('slug')
                                    ->label('URL (Slug)')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Product::class, ignoreRecord: true)
                                    ->prefixIcon('heroicon-o-link')
                                    ->prefixIconColor('success')
                                    ->helperText('Généré automatiquement à partir du nom')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),

                // ========================================
                // SECTION: CLASSIFICATION
                // ========================================
                Section::make('Classification')
                    ->description('Organisez votre produit par catégorie et marque')
                    ->icon('heroicon-o-folder-open')
                    ->iconColor('info')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                Select::make('category_id')
                                    ->label('Catégorie')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->prefixIcon('heroicon-o-folder')
                                    ->native(false)
                                    ->placeholder('Sélectionnez une catégorie')
                                    ->helperText('Classez votre produit dans la bonne catégorie')
                                    ->columnSpan(1),
                                
                                Select::make('brand_id')
                                    ->label('Marque')
                                    ->relationship('brand', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->prefixIcon('heroicon-o-building-office')
                                    ->native(false)
                                    ->placeholder('Sélectionnez une marque')
                                    ->helperText('Associez le produit à sa marque')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),

                // ========================================
                // SECTION: CONTENU VISUEL & DESCRIPTION
                // ========================================
                Section::make('Médias & Description')
                    ->description('Ajoutez des visuels attractifs et décrivez votre produit en détail')
                    ->icon('heroicon-o-photo')
                    ->iconColor('primary')
                    ->collapsible()
                    ->schema([
                        FileUpload::make('images')
                            ->label('Images du produit')
                            ->image()
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '16:9',
                                '4:3',
                            ])
                            ->helperText('Maximum 5 images. Formats acceptés: JPG, PNG, WEBP')
                            ->panelLayout('grid')
                            ->downloadable()
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Description détaillée')
                            ->rows(6)
                            ->placeholder('Décrivez les caractéristiques, avantages et spécificités du produit...')
                            ->helperText('Une description complète améliore le référencement et l\'expérience utilisateur')
                            ->columnSpanFull(),
                    ]),

                // ========================================
                // SECTION: TARIFICATION
                // ========================================
                Section::make('Tarification')
                    ->description('Définissez le prix de vente de votre produit')
                    ->icon('heroicon-o-currency-dollar')
                    ->iconColor('success')
                    ->collapsible()
                    ->schema([
                        TextInput::make('price')
                            ->label('Prix de vente')
                            ->required()
                            ->numeric()
                            ->suffix('CFA')
                            ->step(100)
                            ->minValue(0)
                            ->placeholder('10000')
                            ->prefixIcon('heroicon-o-currency-dollar')
                            ->prefixIconColor('success')
                            ->helperText('Définissez le prix de vente du produit')
                            ->extraInputAttributes(['class' => 'font-bold text-lg'])
                            ->columnSpanFull(),
                    ]),

                // ========================================
                // SECTION: PARAMÈTRES D'AFFICHAGE
                // ========================================
                Section::make('Paramètres & Visibilité')
                    ->description('Configurez l\'affichage et la disponibilité du produit')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->iconColor('gray')
                    ->collapsible()
                    ->schema([
                        Group::make()
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Produit Actif')
                                    ->helperText('Le produit sera visible sur le site')
                                    ->default(true)
                                    ->inline(false)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-o-check-circle')
                                    ->offIcon('heroicon-o-x-circle')
                                    ->columnSpan(1),
                                
                                Toggle::make('is_featured')
                                    ->label('Produit Vedette ⭐')
                                    ->helperText('Affiché dans la section produits mis en avant')
                                    ->default(false)
                                    ->inline(false)
                                    ->onColor('primary')
                                    ->onIcon('heroicon-o-star')
                                    ->offIcon('heroicon-o-star')
                                    ->columnSpan(1),
                                
                                Toggle::make('in_stock')
                                    ->label('En Stock')
                                    ->helperText('Disponible à la vente')
                                    ->default(true)
                                    ->inline(false)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->onIcon('heroicon-o-check-badge')
                                    ->offIcon('heroicon-o-x-circle')
                                    ->columnSpan(1),
                                
                                Toggle::make('on_sale')
                                    ->label('En Promotion 🔥')
                                    ->helperText('Produit en solde ou promotion spéciale')
                                    ->default(false)
                                    ->inline(false)
                                    ->onColor('danger')
                                    ->onIcon('heroicon-o-bolt')
                                    ->offIcon('heroicon-o-bolt-slash')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ]),
            ])
            ->columns(2);
    }
}
