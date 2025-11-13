<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations Générales')
                    ->description('Détails essentiels du produit')
                    ->icon('heroicon-o-information-circle')
                    ->iconColor('primary')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nom du produit')
                            ->icon('heroicon-o-shopping-bag')
                            ->iconColor('primary')
                            ->size('lg')
                            ->weight(FontWeight::Bold)
                            ->copyable()
                            ->copyMessage('Nom copié!')
                            ->columnSpanFull(),
                        
                        TextEntry::make('slug')
                            ->label('Slug')
                            ->icon('heroicon-o-link')
                            ->badge()
                            ->color('gray')
                            ->copyable()
                            ->copyMessage('Slug copié!'),
                        
                        TextEntry::make('category.name')
                            ->label('Catégorie')
                            ->icon('heroicon-o-tag')
                            ->badge()
                            ->color('info'),
                        
                        TextEntry::make('brand.name')
                            ->label('Marque')
                            ->icon('heroicon-o-building-storefront')
                            ->badge()
                            ->color('primary'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Section::make('Médias')
                    ->description('Images du produit')
                    ->icon('heroicon-o-photo')
                    ->iconColor('success')
                    ->schema([
                        ImageEntry::make('images')
                            ->label('Galerie d\'images')
                            ->disk('public')
                            ->circular()
                            ->stacked()
                            ->limit(5)
                            ->limitedRemainingText()
                            ->defaultImageUrl(asset('images/placeholder.png'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Description')
                    ->description('Description détaillée')
                    ->icon('heroicon-o-document-text')
                    ->iconColor('info')
                    ->schema([
                        TextEntry::make('description')
                            ->label('')
                            ->markdown()
                            ->placeholder('Aucune description')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Grid::make(2)
                    ->schema([
                        Section::make('Tarification')
                            ->icon('heroicon-o-currency-dollar')
                            ->iconColor('success')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Prix')
                                    ->numeric(decimalPlaces: 0, thousandsSeparator: ' ')
                                    ->suffix(' FCFA')
                                    ->size('xl')
                                    ->weight(FontWeight::Bold)
                                    ->color('success')
                                    ->icon('heroicon-o-banknotes'),
                            ]),

                        Section::make('Statuts')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->iconColor('primary')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Actif')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                
                                IconEntry::make('is_featured')
                                    ->label('En vedette')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-star')
                                    ->falseIcon('heroicon-o-star')
                                    ->trueColor('primary')
                                    ->falseColor('gray'),
                                
                                IconEntry::make('in_stock')
                                    ->label('En stock')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-badge')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                                
                                IconEntry::make('on_sale')
                                    ->label('En promotion')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-sparkles')
                                    ->falseIcon('heroicon-o-sparkles')
                                    ->trueColor('danger')
                                    ->falseColor('gray'),
                            ])
                            ->columns(2),
                    ]),

                Section::make('Informations temporelles')
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-calendar-days')
                            ->color('success'),
                        
                        TextEntry::make('updated_at')
                            ->label('Modifié le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-pencil-square')
                            ->color('gray')
                            ->since()
                            ->tooltip(fn ($state): string => $state ? $state->format('d/m/Y à H:i') : ''),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
