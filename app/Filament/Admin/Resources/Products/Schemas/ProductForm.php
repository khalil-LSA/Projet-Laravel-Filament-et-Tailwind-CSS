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
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ========================================
                // SECTION: IDENTITÉ DU PRODUIT
                // ========================================
                TextInput::make('name')
                    ->label('Nom du produit')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                    ->prefixIcon('heroicon-o-tag')
                    ->columnSpan(1),
                
                TextInput::make('slug')
                    ->label('URL (Slug)')
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->unique(Product::class, ignoreRecord: true)
                    ->prefixIcon('heroicon-o-link')
                    ->columnSpan(1),

                // ========================================
                // SECTION: CLASSIFICATION
                // ========================================
                Select::make('category_id')
                    ->label('Catégorie')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->prefixIcon('heroicon-o-folder')
                    ->columnSpan(1),
                
                Select::make('brand_id')
                    ->label('Marque')
                    ->options(Brand::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->prefixIcon('heroicon-o-building-office')
                    ->columnSpan(1),

                // ========================================
                // SECTION: CONTENU VISUEL
                // ========================================
                FileUpload::make('images')
                    ->label('Images du produit (Max: 5)')
                    ->image()
                    ->multiple()
                    ->directory('products')
                    ->maxFiles(5)
                    ->reorderable()
                    ->columnSpanFull(),

                // ========================================
                // SECTION: DESCRIPTION
                // ========================================
                Textarea::make('description')
                    ->label('Description détaillée')
                    ->rows(4)
                    ->placeholder('Décrivez les caractéristiques, avantages et spécificités du produit...')
                    ->columnSpanFull(),

                // ========================================
                // SECTION: TARIFICATION
                // ========================================
                TextInput::make('price')
                    ->label('Prix de vente')
                    ->required()
                    ->numeric()
                    ->suffix('CFA')
                    ->step(1)
                    ->placeholder('0')
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->columnSpan(2),

                // ========================================
                // SECTION: PARAMÈTRES D'AFFICHAGE
                // ========================================
                Toggle::make('is_active')
                    ->label('Produit Actif')
                    ->helperText('Le produit sera visible sur le site')
                    ->default(true)
                    ->columnSpan(1),
                
                Toggle::make('is_featured')
                    ->label('Produit Vedette')
                    ->helperText('Affiché dans la section produits mis en avant')
                    ->default(false)
                    ->columnSpan(1),
                
                Toggle::make('in_stock')
                    ->label('En Stock')
                    ->helperText('Disponible à la vente')
                    ->default(true)
                    ->columnSpan(1),
                
                Toggle::make('on_sale')
                    ->label('En Promotion')
                    ->helperText('Produit en solde ou promotion spéciale')
                    ->default(false)
                    ->columnSpan(1),
            ])
            ->columns(2);
    }
}
